<?php

namespace App\Services;

use App\Models\Bank;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BankService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $banks = $isPaginated
        ? Bank::paginate($perPage)
        : Bank::all();
      $banks->load('accountTitle');
      return $banks;
    } catch (Exception $e) {
      Log::info('Error occured during BankService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $bank = Bank::create($data);
      DB::commit();
      $bank->load('accountTitle');
      return $bank;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during BankService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $bank = Bank::find($id);
      $bank->load('accountTitle');
      return $bank;
    } catch (Exception $e) {
      Log::info('Error occured during BankService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $bank = Bank::find($id);
      $bank->update($data);
      DB::commit();
      $bank->load('accountTitle');
      return $bank;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during BankService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $bank = Bank::find($id);
      $bank->secureDelete('disbursements','payments');
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during BankService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
