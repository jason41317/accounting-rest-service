<?php

namespace App\Services;

use App\Models\AccountTitle;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AccountTitleService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $accountTitles = $isPaginated
        ? AccountTitle::paginate($perPage)
        : AccountTitle::all();
      $accountTitles->load(['accountClass', 'parentAccountTitle']);
      return $accountTitles;
    } catch (Exception $e) {
      Log::info('Error occured during AccountTitleService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $accountTitle = AccountTitle::create($data);
      $accountTitle->load(['accountClass', 'parentAccountTitle']);
      DB::commit();
      return $accountTitle;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during AccountTitleService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $accountTitle = AccountTitle::find($id);
      $accountTitle->load(['accountClass', 'parentAccountTitle']);
      return $accountTitle;
    } catch (Exception $e) {
      Log::info('Error occured during AccountTitleService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $accountTitle = AccountTitle::find($id);
      $accountTitle->update($data);
      $accountTitle->load(['accountClass', 'parentAccountTitle']);
      DB::commit();
      return $accountTitle;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during AccountTitleService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $accountTitle = AccountTitle::find($id);
      $accountTitle->secureDelete('parentAccountTitle', 'charges', 'banks', 'ewallets');
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during AccountTitleService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
