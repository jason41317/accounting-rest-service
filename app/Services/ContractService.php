<?php

namespace App\Services;

use App\Models\Billing;
use App\Models\CompanySetting;
use App\Models\Contract;
use App\Models\Payment;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContractService
{
  public function list(bool $isPaginated, int $perPage, array $filters)
  {
    try {
      $query = Contract::with(['services' => function ($q) {
        return $q->with('serviceCategory');
      }, 'businessType', 'businessStyle', 'files', 'contractStatus','client','taxType', 'location' => function ($q) {
        return $q->with('rdo');
      }]);

      $contractStatusId = $filters['contract_status_id'] ?? false;
      $query->when($contractStatusId, function($q) use($contractStatusId) {
        return $q->where('contract_status_id', $contractStatusId);
      });

      $clientId = $filters['client_id'] ?? false;
      $query->when($clientId, function($q) use($clientId) {
        return $q->where('client_id', $clientId);
      });


      $criteria = $filters['criteria'] ?? null;
      $query->when($criteria, function($q) use ($criteria) {
        return $q->where(function ($q) use ($criteria) {
          return $q->filterByCriteria($criteria);
        });
      });


        $filterByUser = $filters['filter_by_user'] ?? null;
        $query->when($filterByUser, function ($q) {
            return $q->filterByUser();
        });



      $sortKey = $filters['sort_key'] ?? 'id';
      $sortDesc = $filters['sort_desc'] ?? 'DESC';;

      $query->orderBy($sortKey, $sortDesc);

      $contracts = $isPaginated
        ? $query->paginate($perPage)
        : $query->get();

      $year = $filters['year'] ?? null;
      $monthId = $filters['month_id'] ?? null;
      $billingId = $filters['billing_id'] ?? null;
      if ($year && $monthId)
      {
        // if (!$previousBalance) {
        foreach ($contracts as $contract) {
          $contract->previous_balance = $this->previousBalance(
            $contract->id,
            $year,
            $monthId,
            $billingId
          );
        }
        // $contracts->append(['is_billed']);
        $contracts->append('previous_balance');
        // } else {
        //   foreach ($contracts as $contract) {
        //     $contract->previous_balance = $this->previousBalance(
        //       $contract->id,
        //       null,
        //       null
        //     );
        //   }
        //   $contracts->append(['previous_balance']);
        // }
      }

      return $contracts;
    } catch (Exception $e) {
      Log::info('Error occured during ContractService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data, array $services, array $charges)
  {
    DB::beginTransaction();
    try {
      $contract = Contract::create($data);

      if ($services) {
        $contract->services()->sync($services);
      }
      if ($charges) {
        $items = [];
        foreach ($charges as $charge) {
          $items[$charge['charge_id']] = [
            'amount' => $charge['amount']
          ];

          $scheduleItems = [];
          foreach ($charge["schedules"] as $schedule) {
            $scheduleItems[$schedule['month_id']] = [
              'charge_id' => $charge['charge_id']
            ];
          }
          $contract->schedules()
            ->wherePivot('charge_id', $charge['charge_id'])
            ->sync($scheduleItems);
        }
        $contract->charges()->sync($items);
      }

      DB::commit();
      return $contract;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ContractService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $query = Contract::find($id);

      $contract = $query->load(['services' => function ($q) {
        return $q->with('serviceCategory');
      }, 'charges' => function ($q) use ($id){
        return $q->with('schedules', function($q) use ($id) {
          $q->wherePivot('contract_id', $id);
        });
      },'businessType', 'businessStyle','approvedByPersonnel','files', 'client', 'taxType', 'contractStatus', 'location' => function($q) {
        return $q->with('rdo');
      }]);

      return $contract->append('grouped_files','charge_balances');
    } catch (Exception $e) {
      Log::info('Error occured during ContractService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, array $services, array $charges, ?array $assignee, int $id)
  {
    DB::beginTransaction();
    try {
      $contract = Contract::find($id);
      $contract->update($data);
      if ($services) {
        $contract->services()->sync($services);
      }
      if ($charges) {
        $items = [];
        foreach ($charges as $charge) {
          $items[$charge['charge_id']] = [
            'amount' => $charge['amount']
          ];

          $scheduleItems = [];
          foreach ($charge["schedules"] as $schedule) {
            $scheduleItems[$schedule['month_id']] = [
              'charge_id' => $charge['charge_id']
            ];
          }
          $contract->schedules()
            ->wherePivot('charge_id', $charge['charge_id'])
            ->sync($scheduleItems);
        }
        $contract->charges()->sync($items);
      }
      if ($assignee) {
        $contract->assignees()->create([
          'personnel_id' => $assignee['personnel_id'],
          'is_active' => 1,
          'date_assigned' => Carbon::now()
        ]);
      }

      DB::commit();
      return $contract;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ContractService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $contract = Contract::find($id);
      $contract->secureDelete('billings', 'payments');
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ContractService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function getContractHistory(int $id, array $filters)
  {
    $filterDate = $filters['as_of_date'] ?? Carbon::now();
    $year = $filters['year'] ?? null;
    $monthId = $filters['month_id'] ?? null;
    $billingId = $filters['billing_id'] ?? null;
    if ($year && $monthId) {
      $filterDate = new Carbon($year . '-' . $monthId . '-1');
    }

    $billings = Billing::where('contract_id', $id)
      ->select(
        'id',
        'billing_no as reference_no',
        'billing_date as reference_date',
        DB::raw('0 as payment_amount'),
        DB::raw('1 as is_billing')
      )
      ->whereRaw('DATE(CONCAT(year,"-",month_id,"-",1)) <= DATE("' . $filterDate . '")')
      ->whereRaw('DATE(created_at) <= DATE("' . Carbon::now() . '")')
      ->when($billingId, function ($q) use ($billingId) {
        return $q->where('id', '<', $billingId);
      })
      ->get();

    $payments = Payment::where('contract_id', $id)
      ->select(
        'id',
        DB::raw('CONCAT(payment_no,"/",transaction_no) as reference_no'),
        'transaction_date as reference_date',
        'amount as payment_amount',
        DB::raw('0 as amount'),
        DB::raw('0 as is_billing')
      )
      ->where('payment_status_id', 2)
      ->whereRaw('DATE(created_at) <= DATE("' . Carbon::now() . '")')
      ->get();
    return $billings->mergeRecursive($payments)->sortBy('reference_date')->all();
  }

  public function previousBalance($contractId, $year, $monthId, $billingId)
  {
    $company = CompanySetting::find(1);
    $filterDate = Carbon::now();
    if ($year && $monthId) {
      $filterDate = new Carbon($year.'-'.$monthId.'-1');
    }
    $billings = Billing::where('contract_id', $contractId)
      ->whereRaw('DATE(CONCAT(year,"-",month_id,"-",1)) <= DATE("' . $filterDate . '")')
      ->whereRaw('DATE(created_at) <= DATE("' . Carbon::now() . '")')
      ->when($billingId, function ($q) use ($billingId) {
        return $q->where('id', '<', $billingId);
      })
      ->get()
      ->sum('amount');
    $payments = Payment::where('contract_id', $contractId)
      ->whereRaw('DATE(created_at) <= DATE("' . Carbon::now() . '")')
      ->where('payment_status_id', 2)
      ->get()
      ->sum('amount');
    return $billings - $payments;
  }
}
