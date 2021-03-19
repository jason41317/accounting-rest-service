<?php

namespace App\Services;

use App\Models\BusinessType;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BusinessTypeService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $businessTypes = $isPaginated
        ? BusinessType::paginate($perPage)
        : BusinessType::all();
      return $businessTypes;
    } catch (Exception $e) {
      Log::info('Error occured during BusinessTypeService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $businessType = BusinessType::create($data);
      DB::commit();
      return $businessType;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during BusinessTypeService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $businessType = BusinessType::find($id);
      return $businessType;
    } catch (Exception $e) {
      Log::info('Error occured during BusinessTypeService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $businessType = BusinessType::find($id);
      $businessType->update($data);
      DB::commit();
      return $businessType;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during BusinessTypeService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $businessType = BusinessType::find($id);
      $businessType->secureDelete('clients');
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during BusinessTypeService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
