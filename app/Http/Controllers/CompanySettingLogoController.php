<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanySettingLogoStoreRequest;
use App\Http\Resources\CompanySettingLogoResource;
use App\Models\CompanySettingLogo;
use App\Services\CompanySettingLogoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class CompanySettingLogoController extends Controller
{
    public function store(CompanySettingLogoStoreRequest $request, $companySettingId)
    {
        try {
            $file = $request->file('photo');
            $companySettingLogoService = new CompanySettingLogoService();
            $companySettingLogo = $companySettingLogoService->store($companySettingId, $file);
            return (new CompanySettingLogoResource($companySettingLogo))
                ->response()
                ->setStatusCode(201);
        } catch (Throwable $e) {
            Log::error('Message occured => ' . $e->getMessage());
            return response()->json([], 400);
        }
    }

    public function destroy($companySettingId)
    {
        try {
            $companySettingLogoService = new CompanySettingLogoService();
            if ($companySettingLogoService->delete($companySettingId)) {
                return response()->json([], 204);
            }
        } catch (Throwable $e) {
            Log::error('Message occured => ' . $e->getMessage());
            return response()->json([], 400);
        }
    }
}
