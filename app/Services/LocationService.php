<?php

namespace App\Services;

use App\Models\Location;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LocationService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $locations = $isPaginated
        ? Location::paginate($perPage)
        : Location::all();
      $locations->load('rdo');
      return $locations;
    } catch (Exception $e) {
      Log::info('Error occured during LocationService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $location = Location::create($data);
      DB::commit();
      $location->load('rdo');
      return $location;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during LocationService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $location = Location::find($id);
      $location->load('rdo');
      return $location;
    } catch (Exception $e) {
      Log::info('Error occured during LocationService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $location = Location::find($id);
      $location->update($data);
      DB::commit();
      $location->load('rdo');
      return $location;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during LocationService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $location = Location::find($id);
      $location->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during LocationService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
