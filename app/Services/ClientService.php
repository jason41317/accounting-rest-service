<?php

namespace App\Services;

use App\Models\Client;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClientService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $query = Client::with(['businessStyle', 'businessType']);
      $clients = $isPaginated
        ? $query->paginate($perPage)
        : $query->get();
      return $clients;
    } catch (Exception $e) {
      Log::info('Error occured during ClientService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data)
  {
    DB::beginTransaction();
    try {
      $client = Client::create($data);
      DB::commit();
      return $client;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ClientService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $client = Client::find($id);
      return $client;
    } catch (Exception $e) {
      Log::info('Error occured during ClientService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    DB::beginTransaction();
    try {
      $client = Client::find($id);
      $client->update($data);
      DB::commit();
      return $client;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ClientService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $client = Client::find($id);
      $client->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during ClientService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}