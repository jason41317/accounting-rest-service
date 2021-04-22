<?php

namespace App\Services;

use App\Models\ClosedBillingPeriod;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClosedBillingPeriodService
{
  public function list(bool $isPaginated, int $perPage, array $filters)
  {
    try {
      $monthId = $filters['month_id'] ?? false;
      $year = $filters['year'] ?? false;

      $query = ClosedBillingPeriod::when($monthId, function ($q) use ($monthId) {
        return $q->where('month_id', $monthId);
      });

      $query->when($year, function ($q) use ($year) {
        return $q->where('year', $year);
      });

      $closedBillingPeriods = $isPaginated
        ? $query->paginate($perPage)
        : $query->get();
      return $closedBillingPeriods;
    } catch (Exception $e) {
      Log::info('Error occured during ClosedBillingPeriodService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $closedBillingPeriod = ClosedBillingPeriod::create($data);
      DB::commit();
      return $closedBillingPeriod;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ClientService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
