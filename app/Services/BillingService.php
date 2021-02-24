<?php

namespace App\Services;

use App\Models\Billing;
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
              return $q->where('trade_name', 'LIKE', '%' . $criteria . '%')
              ->orWhere('contract_no', 'LIKE', '%' . $criteria . '%');
            });
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
}