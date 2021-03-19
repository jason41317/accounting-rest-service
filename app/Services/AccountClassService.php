<?php

namespace App\Services;

use App\Models\AccountClass;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AccountClassService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $accountClasses = $isPaginated
        ? AccountClass::paginate($perPage)
        : AccountClass::all();
      $accountClasses->load('accountType');
      return $accountClasses;
    } catch (Exception $e) {
      Log::info('Error occured during AccountClassService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $accountClass = AccountClass::create($data);
      $accountClass->load('accountType');
      DB::commit();
      return $accountClass;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during AccountClassService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $accountClass = AccountClass::find($id);
      $accountClass->load('accountType');
      return $accountClass;
    } catch (Exception $e) {
      Log::info('Error occured during AccountClassService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $accountClass = AccountClass::find($id);
      $accountClass->update($data);
      $accountClass->load('accountType');
      DB::commit();
      return $accountClass;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during AccountClassService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $accountClass = AccountClass::find($id);
      $accountClass->secureDelete('accountTitles');
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during AccountClassService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
