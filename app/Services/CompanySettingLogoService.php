<?php

namespace App\Services;

use Intervention\Image\Facades\Image;
use PHPUnit\Exception;
use App\Models\CompanySettingLogo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CompanySettingLogoService
{

  public function store($companySettingId, $file)
  {
    try {
      if (!$companySettingId) {
        throw new \Exception('Company setting id not found!');
      }

      if (!$file) {
        throw new \Exception('File not found!');
      }

      $image = Image::make($file)->resize(null, 350, function ($constraint) {
        $constraint->aspectRatio();
      });
      //$path = $request->file('photo')->store('public');
      $path = 'company-logo/' . $file->hashName();
      Storage::put('public/'.$path, $image->stream());

      $CompanySettingLogo = CompanySettingLogo::updateOrCreate(
        ['company_setting_id' => $companySettingId],
        [
          'path' => $path,
          'name' => $file->getClientOriginalName(),
          'hash_name' => $file->hashName()
        ]
      );

      return $CompanySettingLogo;
    } catch (Exception $e) {
      Log::info('Error occured during CompanySettingLogoService store method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }

  public function delete($companySettingId)
  {
    try {
      if (!$companySettingId) {
        throw new \Exception('Company setting id not found!');
      }

      $query = CompanySettingLogo::where('company_setting_id', $companySettingId);
      $photo = $query->first();
      if ($photo) {
        Storage::delete($photo->path);
        $query->delete();
        return true;
      }
      return false;
    } catch (Exception $e) {
      Log::info('Error occured during CompanySettingLogoService update method call: ');
      Log::info($e->getMessage());
      throw $e;
    }
  }
}
