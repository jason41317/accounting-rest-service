<?php

namespace App\Services;

use App\Models\CreditMemo;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreditMemoService
{
  public function list(bool $isPaginated, int $perPage, array $filters)
  {
    try {
      $query = CreditMemo::with(['client', 'contract', 'month']);

      $monthId = $filters['month_id'] ?? false;
      $query->when($monthId, function ($q) use ($monthId) {
        return $q->where('month_id', $monthId);
      });

      $year = $filters['year'] ?? false;
      $query->when($year, function ($q) use ($year) {
        return $q->where('year', $year);
      });

      $criteria = $filters['criteria'] ?? false;
      $query->when($criteria, function ($q) use ($criteria) {
        return $q->where(function ($q) use ($criteria) {
          $q->where('credit_memo_no', 'LIKE', '%' . $criteria . '%')
            ->orWhereHas('client', function ($q) use ($criteria) {
              return $q->where('code', 'LIKE', '%' . $criteria . '%')
                ->orWhere('name', 'LIKE', '%' . $criteria . '%');
            })
            ->orWhereHas('contract', function ($q) use ($criteria) {
              return $q->filterByCriteria($criteria);
            });
        });
      });

        $exemptedUserGroups = Config::get('constants.user_groups_exempted_on_filter');
        $user = Auth::user();
        if(in_array($user->user_group_id, $exemptedUserGroups)){
            $filterByUser = $filters['filter_by_user'] ?? false;
            $query->when($filterByUser, function ($q) {
                return $q->whereHas('contract', function ($query) {
                return $query->filterByUser();
                });
            });
        }

      $sortKey = $filters['sort_key'] ?? 'id';
      $sortDesc = $filters['sort_desc'] ?? 'DESC';
      $query->orderBy($sortKey, $sortDesc);


      $creditMemos = $isPaginated
        ? $query->paginate($perPage)
        : $query->get();
      return $creditMemos;
    } catch (Exception $e) {
      Log::info('Error occured during CreditMemoService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data, array $charges)
  {
    DB::beginTransaction();
    try {
      $creditMemo = CreditMemo::create($data);

      if ($charges) {
        $items = [];
        foreach ($charges as $charge) {
          $items[$charge['charge_id']] = [
            'amount' => $charge['amount'],
            'notes' => $charge['notes']
          ];
        }
        $creditMemo->charges()->sync($items);
      }

      DB::commit();
      return $creditMemo;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during CreditMemoService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $creditMemo = CreditMemo::find($id);

      $creditMemo->load(['client' => function ($q) {
        return $q->with('contracts');
      }, 'charges', 'contract']);

      return $creditMemo;
    } catch (Exception $e) {
      Log::info('Error occured during CreditMemoService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, array $charges, int $id)
  {
    DB::beginTransaction();
    try {
      $creditMemo = CreditMemo::find($id);
      $creditMemo->update($data);

      if ($charges) {
        $items = [];
        foreach ($charges as $charge) {
          $items[$charge['charge_id']] = [
            'amount' => $charge['amount'],
            'notes' => $charge['notes']
          ];
        }
        $creditMemo->charges()->sync($items);
      }
      DB::commit();
      return $creditMemo;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during CreditMemoService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $creditMemo = CreditMemo::find($id);
      $creditMemo->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during CreditMemoService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function charges(int $creditMemoId, array $filters)
  {
    $query = CreditMemo::with(['client', 'contract', 'month'])
    ->where('is_applied', 0);

    $monthId = $filters['month_id'] ?? false;
    $query->when($monthId, function ($q) use ($monthId) {
      return $q->where('month_id', $monthId);
    });

    $year = $filters['year'] ?? false;
    $query->when($year, function ($q) use ($year) {
      return $q->where('year', $year);
    });

    $contractId = $filters['contract_id'] ?? false;
    $query->when($contractId, function ($q) use ($contractId) {
      return $q->where('contract_id', $contractId);
    });

    if ($creditMemoId) {
      $creditMemo = $query->find($creditMemoId);
      $charges = $creditMemo->charges()->get();
      return $charges;
    }

    $creditMemos = $query->with('charges')->get();
    $charges = $creditMemos->pluck('charges')->flatten();

    return $charges;
  }
}
