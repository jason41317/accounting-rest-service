<?php

namespace App\Services;

use App\Models\Payment;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
  public function list(bool $isPaginated, int $perPage, array $filters)
  {
    try {
      $query = Payment::with(['client', 'contract', 'paymentType', 'paymentStatus']);

      $paymentStatusId = $filters['payment_status_id'] ?? false;
      $query->when($paymentStatusId, function($q) use($paymentStatusId) {
        return $q->where('payment_status_id', $paymentStatusId);
      });

      $filterByUser = $filters['filter_by_user'] ?? false;
      $query->when($filterByUser, function ($q) {
        return $q->whereHas('contract', function ($query) {
          return $query->filterByUser();
        });
      });

      $criteria = $filters['criteria'] ?? false;
      $query->when($criteria, function ($q) use ($criteria) {
        return $q->where(function ($q) use ($criteria) {
          $q->where('payment_no', 'LIKE', '%' . $criteria . '%')
            ->orWhereHas('client', function ($q) use ($criteria) {
              return $q->where('code', 'LIKE', '%' . $criteria . '%')
                ->orWhere('name', 'LIKE', '%' . $criteria . '%');
            })
            ->orWhereHas('contract', function ($q) use ($criteria) {
              return $q->where('trade_name', 'LIKE', '%' . $criteria . '%')
                ->orWhere('contract_no', 'LIKE', '%' . $criteria . '%');
            });
        });
      });

      $payments = $isPaginated
        ? $query->paginate($perPage)
        : $query->get();

      return $payments;
    } catch (Exception $e) {
      Log::info('Error occured during PaymentService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data, array $charges)
  {
    DB::beginTransaction();
    try {
      $payment = Payment::create($data);
      
      if ($charges) {
        $items = [];
        foreach ($charges as $charge) {
          $items[$charge['charge_id']] = [
            'amount' => $charge['amount'],
            'for_deposit' => $charge['for_deposit'] ? $charge['for_deposit']  : 0
          ];
        }
        $payment->charges()->sync($items);
      }

      DB::commit();
      return $payment;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during PaymentService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $payment = Payment::find($id);

      $payment->load(['client' => function ($q) {
        return $q->with('contracts');
      }, 'charges', 'contract', 'paymentType', 'paymentStatus', 'bank', 'eWallet', 'approvedByPersonnel']);

      return $payment;
    } catch (Exception $e) {
      Log::info('Error occured during PaymentService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, array $charges, int $id)
  {
    DB::beginTransaction();
    try {
      $payment = Payment::find($id);
      $payment->update($data);

      if ($charges) {
        $items = [];
        foreach ($charges as $charge) {
          $items[$charge['charge_id']] = [
            'amount' => $charge['amount'],
            'for_deposit' => $charge['for_deposit']
          ];
        }
        $payment->charges()->sync($items);
      }

      DB::commit();
      return $payment;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during PaymentService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $payment = Payment::find($id);
      $payment->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during PaymentService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function yearlyComparison(array $filters)
  {
    try {
      $year = $filters['year'] ?? null;
      $currentYear = $year ?? Carbon::now()->year;
      $previousYear = $currentYear - 1;
      $currentYearData = Payment::whereYear('created_at', $currentYear)->get()
      ->groupBy(function ($val) {
        return (int)Carbon::parse($val->created_at)->format('m');
      })->map(function ($row) {
        return $row->sum('amount');
      });
      $previousYearData = Payment::whereYear('created_at', $previousYear)->get()
      ->groupBy(function ($val) {
        return (int)Carbon::parse($val->created_at)->format('m');
      })->map(function ($row) {
        return $row->sum('amount');
      });

      $payment['current_year'] = $currentYearData;
      $payment['previous_year'] = $previousYearData;

      return $payment;
    } catch (Exception $e) {
      Log::info('Error occured during PaymentService yearlyComparison method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
  
  public function collectionBreakDown(array $filters)
  {
    $dateFrom = $filters['date_from'] ?? null;
    $dateTo = $filters['date_to'] ?? null;
    $payments = Payment::when($dateFrom && $dateTo, function ($q) use ($dateFrom, $dateTo) {
      return $q->whereBetween('created_at', [date('Y-m-d', strtotime($dateFrom)), date('Y-m-d', strtotime($dateTo))]);
    })
    ->get()
    ->groupBy('payment_type_id')
    ->map(function($row) {
      return $row->sum('amount');
    });

    return $payments;
  }
}
