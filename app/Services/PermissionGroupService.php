<?php

namespace App\Services;

use App\Models\Location;
use App\Models\PermissionGroup;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PermissionGroupService
{
  public function list(bool $isPaginated, int $perPage)
  {
    try {
      $permissionGroups = $isPaginated
        ? PermissionGroup::paginate($perPage)
        : PermissionGroup::all();
      $permissionGroups->load('permissions');
      return $permissionGroups;
    } catch (Exception $e) {
      Log::info('Error occured during PermissionGroupService list method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}