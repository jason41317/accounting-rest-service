<?php

namespace App\Services;

use App\Models\Rdo;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RdoService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $rdos = $isPaginated
        ? Rdo::paginate($perPage)
        : Rdo::all();
      return $rdos;
    } catch (Exception $e) {
      Log::info('Error occured during RdoService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $rdo = Rdo::create($data);
      DB::commit();
      return $rdo;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during RdoService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $rdo = Rdo::find($id);
      return $rdo;
    } catch (Exception $e) {
      Log::info('Error occured during RdoService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $rdo = Rdo::find($id);
      $rdo->update($data);
      DB::commit();
      return $rdo;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during RdoService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $rdo = Rdo::find($id);
      $rdo->secureDelete('locations');
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during RdoService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
