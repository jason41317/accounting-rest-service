<?php

namespace App\Services;

use App\Models\Service;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiceService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $services = $isPaginated
        ? Service::paginate($perPage)
        : Service::all();
      $services->load('serviceCategory');
      return $services;
    } catch (Exception $e) {
      Log::info('Error occured during ServiceService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $service = Service::create($data);
      $service->load('serviceCategory');
      DB::commit();
      return $service;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ServiceService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $service = Service::find($id);
      $service->load('serviceCategory');
      return $service;
    } catch (Exception $e) {
      Log::info('Error occured during ServiceService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $service = Service::find($id);
      $service->update($data);
      $service->load('serviceCategory');
      DB::commit();
      return $service;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ServiceService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $service = Service::find($id);
      $service->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ServiceService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
