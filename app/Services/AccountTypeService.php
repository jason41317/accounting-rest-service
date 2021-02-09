<?php

namespace App\Services;

use App\Models\AccountType;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AccountTypeService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $accountTypes = $isPaginated
        ? AccountType::paginate($perPage)
        : AccountType::all();
      return $accountTypes;
    } catch (Exception $e) {
      Log::info('Error occured during AccountTypeService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $accountType = AccountType::create($data);
      DB::commit();
      return $accountType;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during AccountTypeService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $accountType = AccountType::find($id);
      return $accountType;
    } catch (Exception $e) {
      Log::info('Error occured during AccountTypeService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $accountType = AccountType::find($id);
      $accountType->update($data);
      DB::commit();
      return $accountType;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during AccountTypeService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $accountType = AccountType::find($id);
      $accountType->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during AccountTypeService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
