<?php

namespace App\Services;

use App\Models\BillingPeriod;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BillingPeriodService
{
  public function list(bool $isPaginated, int $perPage, array $filters)
  {
    try {
      $query = BillingPeriod::with('month');

      $asOfDate = $filters['as_of_date'] ?? false;

      $query->when($asOfDate, function ($q) {
        $now = Carbon::now();
        $asOfDate = $now->year.'-'.$now->month.'-1';
        return $q->whereRaw('DATE(CONCAT(year,"-",month_id,"-",1)) >= DATE("' . $asOfDate . '")');
      });

      $billingPeriods = $isPaginated
        ? $query->paginate($perPage)
        : $query->get();
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

  public function setActive(int $id) {
    $billingPeriod = BillingPeriod::find($id);

    DB::beginTransaction();
    try {
      $billingPeriod->update([
        'is_active' => 1
      ]);
      $this->setInactive($id);
      DB::commit();
      return $billingPeriod;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during BillingPeriodService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
