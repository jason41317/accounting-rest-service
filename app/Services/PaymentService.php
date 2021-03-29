<?php

namespace App\Services;

use App\Models\Payment;
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
      $count = Payment::count();
      $payment->update([
        'payment_no' => 'PAY-' . date('Y') . '-' . str_pad($count, 6, '0', STR_PAD_LEFT)
      ]);
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
}
