<?php

namespace App\Services;

use App\Models\BillingPeriod;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BillingPeriodService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $billingPeriods = $isPaginated
        ? BillingPeriod::paginate($perPage)
        : BillingPeriod::all();
      $billingPeriods->load('month');
      return $billingPeriods;
    } catch (Exception $e) {
      Log::info('Error occured during BillingPeriodService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $billingPeriod = BillingPeriod::create($data);
      $billingPeriod->load('month');
      $this->setInactive($billingPeriod->id);
      DB::commit();
      return $billingPeriod;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during BillingPeriodService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $billingPeriod = BillingPeriod::find($id);
      $billingPeriod->load('month');
      return $billingPeriod;
    } catch (Exception $e) {
      Log::info('Error occured during BillingPeriodService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $billingPeriod = BillingPeriod::find($id);
      $billingPeriod->update($data);
      $billingPeriod->load('month');
      // $this->setInactive($id);
      DB::commit();
      return $billingPeriod;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during BillingPeriodService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $billingPeriod = BillingPeriod::find($id);
      $billingPeriod->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during BillingPeriodService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function setInactive(int $id)
  {
    BillingPeriod::where('id', '!=', $id)
      ->update([
        'is_active' => 0
      ]);
  }
}
