<?php

namespace App\Services;

use App\Models\Contract;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContractService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $query = Contract::with(['services' => function ($q) {
        return $q->with('serviceCategory');
      }, 'charges' , 'files']);
      
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
      Log::info('Error occured during BusinessStyleService store method call: ');
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
      }, 'files']);

      return $contract->append('grouped_files');
    } catch (Exception $e) {
      Log::info('Error occured during ContractService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
   
  }

  public function delete(int $id)
  {
    
  }
}