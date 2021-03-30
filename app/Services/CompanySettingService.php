<?php

namespace App\Services;

use Exception;
use App\Models\CompanySetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompanySettingService
{

  public function get(int $id)
  {
    try {
      $companySetting = CompanySetting::find($id);

      return $companySetting;
    } catch (Exception $e) {
      Log::info('Error occured during CompanySettingService get method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }



  
}
