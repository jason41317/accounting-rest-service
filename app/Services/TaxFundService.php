<?php

namespace App\Services;

use App\Models\TaxFund;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaxFundService
{
  public function list(bool $isPaginated, int $perPage, array $filters)
  {
    try {
      $dateFrom = $filters['date_from'] ?? false;
      $dateTo = $filters['date_to'] ?? false;

      $query = TaxFund::when($dateFrom && $dateTo, function ($q) use ($dateFrom, $dateTo) {
        return $q->whereRaw('DATE(created_at) BETWEEN "'.$dateFrom.'" AND "'.$dateTo.'"');
      });

      $sortKey = $filters['sort_key'] ?? 'id';
      $sortDesc = $filters['sort_desc'] ?? 'DESC';
      $query->orderBy($sortKey, $sortDesc);

      $TaxFunds = $isPaginated
        ? $query->paginate($perPage)
        : $query->get();
      return $TaxFunds;
    } catch (Exception $e) {
      Log::info('Error occured during TaxFundService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $taxFund = TaxFund::create($data);
      DB::commit();
      $taxFund->load('createdByUser');
      return $taxFund;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during TaxFundService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $taxFund = TaxFund::find($id);
      return $taxFund;
    } catch (Exception $e) {
      Log::info('Error occured during TaxFundService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $taxFund = TaxFund::find($id);
      $taxFund->update($data);
      DB::commit();
      return $taxFund;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during TaxFundService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $taxFund = TaxFund::find($id);
      $taxFund->secureDelete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during TaxFundService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
