<?php

namespace App\Services;

use App\Models\Billing;
use App\Models\CompanySetting;
use App\Models\Contract;
use App\Models\Payment;
use Carbon\Carbon;
use Exception;
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
      
      $contracts = $isPaginated
        ? $query->paginate($perPage)
        : $query->get();

      $year = $filters['year'] ?? null;
      $monthId = $filters['month_id'] ?? null;
      // $previousBalance = $filters['previous_balance'] ?? null;
      if ($year && $monthId)
      {
        // if (!$previousBalance) {
        foreach ($contracts as $contract) {
          $contract->is_billed = $this->isBilled(
            $contract->id,
            $year,
            $monthId
          );
          $contract->previous_balance = $this->previousBalance(
            $contract->id,
            $year,
            $monthId
          );
        }
        $contracts->append(['is_billed']);
        $contracts->append(['previous_balance']);
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
      $count = Contract::count();
      $contract->update([
        'contract_no' => 'CN-' . date('Y') . '-' . str_pad($count, 6, '0', STR_PAD_LEFT)
      ]);
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

      return $contract->append('grouped_files','charge_balances','current_assignee');
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
      $contract->secureDelete('billing', 'payment');
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
    $company = CompanySetting::find(1);
    $filterDate = $filters['as_of_date'] ?? Carbon::now();
    $year = $filters['year'] ?? null; 
    $monthId = $filters['month_id'] ?? null;
    if ($year && $monthId) {
      $filterDate = new Carbon($year . '-' . $monthId . '-' . $company->billing_cutoff_day);
    }

    $billings = Billing::where('contract_id', $id)
      ->select(
        'id',
        'billing_no as reference_no',
        'billing_date as reference_date',
        DB::raw('0 as payment_amount')
      )
      ->whereRaw('DATE(CONCAT(year,"-",month_id,"-",1)) <= DATE("' . $filterDate . '")')
      ->get();
    
    $payments = Payment::where('contract_id', $id)
      ->select(
        'id',
        DB::raw('CONCAT(payment_no,"/",transaction_no) as reference_no'),
        'transaction_date as reference_date',
        'amount as payment_amount',
        DB::raw('0 as amount')
      )
      ->where('payment_status_id', 2)
      ->whereRaw('DATE(transaction_date) <= DATE("' . $filterDate . '")')
      ->get();
    return $billings->mergeRecursive($payments)->sortBy('reference_date')->all();
  }

  public function isBilled($contractId, $year, $monthId)
  {
    $billings = Billing::where('contract_id', $contractId)
      ->where('year', $year)
      ->where('month_id', $monthId)
      ->get();

    if(count($billings) > 0) {
      return true;
    }

    return false;
  }

  public function previousBalance($contractId, $year, $monthId)
  {
    $company = CompanySetting::find(1);
    $filterDate = Carbon::now();
    if ($year && $monthId) {
      $filterDate = new Carbon($year.'-'.$monthId.'-'.$company->billing_cutoff_day);
    }
    $billings = Billing::where('contract_id', $contractId)
      ->whereRaw('DATE(CONCAT(year,"-",month_id,"-",1)) <= DATE("' . $filterDate . '")')
      ->get()
      ->sum('amount');
    $payments = Payment::where('contract_id', $contractId)
      ->whereRaw( 'DATE(transaction_date) <= DATE("' . $filterDate . '")')
      ->where('payment_status_id', 2)
      ->get()
      ->sum('amount');
    return $billings - $payments;
  }
}
