<?php

namespace App\Services;

use App\Models\Billing;
use App\Models\CompanySetting;
use App\Models\Contract;
use App\Models\Month;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BillingService
{
  public function list(bool $isPaginated, int $perPage, array $filters)
  {
    try {
      $query = Billing::with(['client', 'contract', 'month']);

      $monthId = $filters['month_id'] ?? false;
      $query->when($monthId, function($q) use($monthId) {
        return $q->where('month_id', $monthId);
      });

      $year = $filters['year'] ?? false;
      $query->when($year, function($q) use($year) {
        return $q->where('year', $year);
      });

      $criteria = $filters['criteria'] ?? false;
      $query->when($criteria, function($q) use($criteria) {
        return $q->where(function ($q) use ($criteria) {
          $q->where('billing_no', 'LIKE', '%' . $criteria . '%')
            ->orWhereHas('client', function($q) use($criteria) {
              return $q->where('code', 'LIKE', '%' . $criteria . '%')
              ->orWhere('name', 'LIKE', '%' . $criteria . '%');
            })
            ->orWhereHas('contract', function($q) use($criteria) {
              return $q->filterByCriteria($criteria);
            });
        });
      });

      $filterByUser = $filters['filter_by_user'] ?? false;
      $query->when($filterByUser, function ($q) {
        return $q->whereHas('contract', function ($query) {
          return $query->filterByUser();
        });
      });


      $billings = $isPaginated
        ? $query->paginate($perPage)
        : $query->get();
      return $billings;

    } catch (Exception $e) {
      Log::info('Error occured during BillingService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data, array $charges, array $adjustmentCharges)
  {
    DB::beginTransaction();
    try {
      $billing = Billing::create($data);
      $count = Billing::count();
      $billing->update([
        'billing_no' => 'BN-' . date('Y') . '-' . str_pad($count, 6, '0', STR_PAD_LEFT)
      ]);
      if ($charges) {
        $items = [];
        foreach ($charges as $charge) {
          $items[$charge['charge_id']] = [
            'amount' => $charge['amount'],
            'notes' => $charge['notes']
          ];
        }
        $billing->charges()->sync($items);
      }

      if ($adjustmentCharges) {
        $items = [];
        foreach ($adjustmentCharges as $charge) {
          $items[$charge['charge_id']] = [
            'amount' => $charge['amount'],
            'notes' => $charge['notes']
          ];
        }
        $billing->adjustmentCharges()->sync($items);
      }

      DB::commit();
      return $billing;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during BillingService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $billing = Billing::find($id);

      $billing->load(['client' => function($q) {
        return $q->with('contracts');
      }, 'charges', 'adjustmentCharges', 'contract']);

      return $billing;
    } catch (Exception $e) {
      Log::info('Error occured during BillingService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, array $charges, array $adjustmentCharges, int $id)
  {
    DB::beginTransaction();
    try {
      $billing = Billing::find($id);
      $billing->update($data);

      if ($charges) {
        $items = [];
        foreach ($charges as $charge) {
          $items[$charge['charge_id']] = [
            'amount' => $charge['amount'],
            'notes' => $charge['notes']
          ];
        }
        $billing->charges()->sync($items);
      }

      if ($adjustmentCharges) {
        $items = [];
        foreach ($adjustmentCharges as $charge) {
          $items[$charge['charge_id']] = [
            'amount' => $charge['amount'],
            'notes' => $charge['notes']
          ];
        }
        $billing->adjustmentCharges()->sync($items);
      }

      DB::commit();
      return $billing;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during BillingService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $billing = Billing::find($id);
      $billing->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during BillingService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function batchStore(array $data)
  {
    $company = CompanySetting::find(1);
    $query = Contract::whereHas('billings', function ($q) use ($data) {
        return $q->whereRaw('CONCAT(year,"-",month_id,"-",1) != CONCAT('.$data['year'].',"-",'.$data['month_id'].',"-",1)');
      })
      ->orWhereDoesntHave('billings')
      ->whereHas('charges', function ($q) use ($data) {
        return $q->whereHas('schedules', function ($q) use ($data) {
          return $q->where('month_id', $data['month_id']);
        });
      });

    $taxTypeId = $data['tax_type_id'] ?? null;
    $query->when($taxTypeId, function ($q) use ($taxTypeId) {
      return $q->where('tax_type_id', $taxTypeId);
    });

    $businessTypeId = $data['business_type_id'] ?? null;
    $query->when($businessTypeId, function ($q) use ($businessTypeId) {
      return $q->where('business_type_id', $businessTypeId);
    });

    $businessStyleId = $data['business_style_id'] ?? null;
    $query->when($businessStyleId, function ($q) use ($businessStyleId) {
      return $q->where('business_style_id', $businessStyleId);
    });

    $filterByUser = $data['filter_by_user'] ?? null;
    $query->when($filterByUser, function ($q) {
      return $q->filterByUser();
    });

    $contracts = $query->get();

    $billings = [];
    foreach ($contracts as $contract) {
      $data = array(
        'contract_id' => $contract['id'],
        'client_id' => $contract['client_id'],
        'billing_date' => $data['billing_date'],
        'due_date' => $data['due_date'],
        'year' => $data['year'],
        'month_id' => $data['month_id'],
        'cutoff_day' => $company->billing_cutoff_day
      );

      $charges = array_map(function($charge) {
        return array(
          'charge_id' => $charge['id'],
          'amount' => $charge['pivot']['amount'],
          'notes' => ''
        );
      },
      $contract['charges']->all());

      $billings[] = $this->store($data, $charges, []);
    }

    return $billings;
  }
}