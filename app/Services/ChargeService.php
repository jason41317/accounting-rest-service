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
      $charge = Charge::create($data);
      $charge->load('accountTitle');
      DB::commit();
      return $charge;
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
      $charge = Charge::find($id);
      $charge->load('accountTitle');
      return $charge;
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
      $charge = Charge::find($id);
      $charge->update($data);
      $charge->load('accountTitle');
      DB::commit();
      return $charge;
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
      $charge = Charge::find($id);
      $charge->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ChargeService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
