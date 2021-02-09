<?php

namespace App\Services;

use App\Models\BusinessStyle;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BusinessStyleService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $businessStyles = $isPaginated
        ? BusinessStyle::paginate($perPage)
        : BusinessStyle::all();
      return $businessStyles;
    } catch (Exception $e) {
      Log::info('Error occured during BusinessStyleService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $businessStyle = BusinessStyle::create($data);
      DB::commit();
      return $businessStyle;
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
      $businessStyle = BusinessStyle::find($id);
      return $businessStyle;
    } catch (Exception $e) {
      Log::info('Error occured during BusinessStyleService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $businessStyle = BusinessStyle::find($id);
      $businessStyle->update($data);
      DB::commit();
      return $businessStyle;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during BusinessStyleService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $businessStyle = BusinessStyle::find($id);
      $businessStyle->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during BusinessStyleService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
