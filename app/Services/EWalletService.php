<?php

namespace App\Services;

use App\Models\Ewallet;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EwalletService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $eWallets = $isPaginated
        ? Ewallet::paginate($perPage)
        : Ewallet::all();
      $eWallets->load('accountTitle');
      return $eWallets;
    } catch (Exception $e) {
      Log::info('Error occured during EwalletService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $eWallet = Ewallet::create($data);
      DB::commit();
      $eWallet->load('accountTitle');
      return $eWallet;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during EwalletService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $eWallet = Ewallet::find($id);
      $eWallet->load('accountTitle');
      return $eWallet;
    } catch (Exception $e) {
      Log::info('Error occured during EwalletService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $eWallet = Ewallet::find($id);
      $eWallet->update($data);
      DB::commit();
      $eWallet->load('accountTitle');
      return $eWallet;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during EwalletService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $eWallet = Ewallet::find($id);
      $eWallet->secureDelete('payments');
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during EwalletService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
