<?php

namespace App\Services;

use App\Models\Charge;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChargeService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $charges = $isPaginated
        ? Charge::paginate($perPage)
        : Charge::all();
      $charges->load('accountTitle');
      return $charges;
    } catch (Exception $e) {
      Log::info('Error occured during ChargeService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $accountClass = Charge::create($data);
      $accountClass->load('accountTitle');
      DB::commit();
      return $accountClass;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ChargeService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $accountClass = Charge::find($id);
      $accountClass->load('accountTitle');
      return $accountClass;
    } catch (Exception $e) {
      Log::info('Error occured during ChargeService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $accountClass = Charge::find($id);
      $accountClass->update($data);
      $accountClass->load('accountTitle');
      DB::commit();
      return $accountClass;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ChargeService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $accountClass = Charge::find($id);
      $accountClass->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ChargeService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
