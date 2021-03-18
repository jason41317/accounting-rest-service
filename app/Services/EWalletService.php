<?php

namespace App\Services;

use App\Models\EWallet;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EWalletService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $eWallets = $isPaginated
        ? EWallet::paginate($perPage)
        : EWallet::all();
      return $eWallets;
    } catch (Exception $e) {
      Log::info('Error occured during EWalletService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $eWallet = EWallet::create($data);
      DB::commit();
      return $eWallet;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during EWalletService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $eWallet = EWallet::find($id);
      return $eWallet;
    } catch (Exception $e) {
      Log::info('Error occured during EWalletService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $eWallet = EWallet::find($id);
      $eWallet->update($data);
      DB::commit();
      return $eWallet;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during EWalletService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $eWallet = EWallet::find($id);
      $eWallet->secureDelete('payments');
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during EWalletService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
