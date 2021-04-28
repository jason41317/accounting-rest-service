<?php

namespace App\Services;

use Exception;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SystemSettingService
{

  public function get(int $id)
  {
    try {
      $systemSetting = SystemSetting::find($id);
      // $systemSetting->load('logo');
      return $systemSetting;
    } catch (Exception $e) {
      Log::info('Error occured during SystemSettingService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function update(array $data, int $id)
  {
    try {
      $systemSetting = SystemSetting::find($id);
      $systemSetting->update($data);
      return $systemSetting;
    } catch (Exception $e) {
      Log::info('Error occured during SystemSettingService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
