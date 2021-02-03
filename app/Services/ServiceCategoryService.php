<?php

namespace App\Services;

use App\Models\ServiceCategory;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceCategoryService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $serviceCategories = $isPaginated
        ? ServiceCategory::paginate($perPage)
        : ServiceCategory::all();
      return $serviceCategories;
    } catch (Exception $e) {
      Log::info('Error occured during ServiceCategoryService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $serviceCategory = ServiceCategory::create($data);
      DB::commit();
      return $serviceCategory;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ServiceCategoryService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $serviceCategory = ServiceCategory::find($id);
      return $serviceCategory;
    } catch (Exception $e) {
      Log::info('Error occured during ServiceCategoryService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $serviceCategory = ServiceCategory::find($id);
      $serviceCategory->update($data);
      DB::commit();
      return $serviceCategory;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ServiceCategoryService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $serviceCategory = ServiceCategory::find($id);
      $serviceCategory->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ServiceCategoryService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}