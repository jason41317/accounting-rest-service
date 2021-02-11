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
      }, 'contractCharges', 'files']);

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

  public function store(array $data)
  {
    
  }

  public function get(int $id)
  {
    try {
      $query = Contract::find($id);

      $contract = $query->load(['services' => function ($q) {
        return $q->with('serviceCategory');
      }, 'contractCharges', 'files']);

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