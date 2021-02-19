<?php

namespace App\Services;

use App\Models\Billing;
use App\Models\Month;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BillingService
{
  public function list(bool $isPaginated, int $perPage, array $filters)
  {
    try {
      $query = Billing::with(['client', 'contract', 'month']);
     
      $monthId = $filters['month_id'] ?? false;
      $query->when($monthId, function($q) use($monthId) {
        return $q->where('month_id', $monthId);
      });

      $year = $filters['year'] ?? false;
      $query->when($year, function($q) use($year) {
        return $q->where('year', $year);
      });

      $billings = $isPaginated
        ? $query->paginate($perPage)
        : $query->get();
      return $billings;

    } catch (Exception $e) {
      Log::info('Error occured during BillingService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    
  }

  public function get(int $id)
  {
    try {
      $billing = Billing::find($id);
      
      $billing->load(['client' => function($q) {
        return $q->with('contracts');
      }, 'charges', 'adjustmentCharges', 'contract']);
      
      return $billing;
    } catch (Exception $e) {
      Log::info('Error occured during BillingService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    
  }

  public function delete(int $id)
  {
    
  }
}