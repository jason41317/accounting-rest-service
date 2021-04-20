<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanySettingUpdateRequest;
use Illuminate\Http\Request;
use App\Models\CompanySetting;
use App\Services\CompanySettingService;
use App\Http\Resources\CompanySettingResource;

class CompanySettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompanySetting  $companySetting
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $companySettingService = new CompanySettingService();
        $companySetting = $companySettingService->get($id);
        return new CompanySettingResource($companySetting);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanySetting  $companySetting
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanySetting $companySetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompanySetting  $companySetting
     * @return \Illuminate\Http\Response
     */
    public function update(CompanySettingUpdateRequest $request, int $id)
    {
        $data = $request->all();
        $companySettingService = new CompanySettingService();
        $companySetting = $companySettingService->update($data, $id);
        return (new CompanySettingResource($companySetting))
            ->response()
            ->setStatusCode(200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanySetting  $companySetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanySetting $companySetting)
    {
        //
    }
}
