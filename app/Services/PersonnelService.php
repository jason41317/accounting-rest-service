<?php

namespace App\Services;

use App\Models\Personnel;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PersonnelService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $personnels = $isPaginated
        ? Personnel::paginate($perPage)
        : Personnel::all();
      $personnels->load(['user' => function ($q) {
        return $q->with('userGroup');
      }]);
      return $personnels;
    } catch (Exception $e) {
      Log::info('Error occured during PersonnelService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function store(array $data, array $userData)
  {
    DB::beginTransaction();
    try {
      $personnel = Personnel::create($data);
      if ($userData) {
        $personnel->user()->create([
          'username' => $userData['username'],
          'password' => Hash::make($userData['password']),
          'user_group_id' => $userData['user_group_id']
        ]);
      }
      $personnel->load(['user' => function ($q) {
        return $q->with('userGroup');
      }]);
      DB::commit();
      return $personnel;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during PersonnelService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function get(int $id)
  {
    try {
      $personnel = Personnel::find($id);
      $personnel->load(['user' => function ($q) {
        return $q->with('userGroup');
      }]);
      return $personnel;
    } catch (Exception $e) {
      Log::info('Error occured during PersonnelService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, array $userData, int $id)
  {
    DB::beginTransaction();
    try {
      $personnel = Personnel::find($id);
      $personnel->update($data);
      if ($userData) {
        $personnel->user()->update([
          'username' => $userData['username'],
          'password' => Hash::make($userData['password']),
          'user_group_id' => $userData['user_group_id']
        ]);
      }
      $personnel->load(['user' => function ($q) {
        return $q->with('userGroup');
      }]);
      DB::commit();
      return $personnel;
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during PersonnelService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete(int $id)
  {
    DB::beginTransaction();
    try {
      $personnel = Personnel::find($id);
      $personnel->delete();
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::info('Error occured during PersonnelService delete method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
