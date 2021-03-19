<?php

namespace App\Services;

use App\Models\TaxType;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaxTypeService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $taxTypes = $isPaginated
        ? TaxType::paginate($perPage)
        : TaxType::all();
      return $taxTypes;
    } catch (Exception $e) {
      Log::info('Error occured during TaxTypeService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $taxType = TaxType::create($data);
      DB::commit();
      return $taxType;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during TaxTypeService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $taxType = TaxType::find($id);
      return $taxType;
    } catch (Exception $e) {
      Log::info('Error occured during TaxTypeService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $taxType = TaxType::find($id);
      $taxType->update($data);
      DB::commit();
      return $taxType;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during TaxTypeService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $taxType = TaxType::find($id);
      $taxType->secureDelete('contracts');
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during TaxTypeService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
