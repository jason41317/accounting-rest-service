<?php

namespace App\Services;

use App\Models\Contract;
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
      }, 'charges', 'files', 'contractStatus','client','taxType', 'location' => function ($q) {
        return $q->with('rdo');
      }]);

      $contractStatusId = $filters['contract_status_id'] ?? false;
      $query->when($contractStatusId, function($q) use($contractStatusId) {
        return $q->where('contract_status_id', $contractStatusId);
      });
      

      $criteria = $filters['criteria'] ?? null;
      $query->when($criteria, function($q) use ($criteria) {
        return $q->where(function ($q) use ($criteria) {
          return $q->where('trade_name', 'LIKE', '%'.$criteria.'%')
            ->orWhere('contract_no', 'LIKE', '%' . $criteria . '%')
            ->orWhere('billing_address', 'LIKE', '%' . $criteria . '%')
            ->orWhere('contact_person', 'LIKE', '%' . $criteria . '%')
            ->orWhere('contact_no', 'LIKE', '%' . $criteria . '%')
            ->orWhere('tin', 'LIKE', '%' . $criteria . '%');
        });
      });
      
      $contracts = $isPaginated
        ? $query->paginate($perPage)
        : $query->get();
      
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
      }, 'assignedPersonnel','approvedByPersonnel','files', 'client', 'taxType', 'contractStatus', 'location' => function($q) {
        return $q->with('rdo');
      }]);

      return $contract->append('grouped_files','charge_balances');
    } catch (Exception $e) {
      Log::info('Error occured during ContractService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, array $services, array $charges, int $id)
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
      $contract->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ContractService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function getChargesBalanceOfContracts(int $contractId)
  {
    DB::beginTransaction();
    try {
      $contract = Contract::find($id);
      $contract->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ContractService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
