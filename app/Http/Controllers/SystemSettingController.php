<?php

namespace App\Http\Controllers;

use App\Http\Requests\SystemSettingUpdateRequest;
use Illuminate\Http\Request;
use App\Models\SystemSetting;
use App\Services\SystemSettingService;
use App\Http\Resources\SystemSettingResource;

class SystemSettingController extends Controller
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
     * @param  \App\Models\SystemSetting  $systemSetting
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $systemSettingService = new SystemSettingService();
        $systemSetting = $systemSettingService->get($id);
        return new SystemSettingResource($systemSetting);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SystemSetting  $systemSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(SystemSetting $systemSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SystemSetting  $systemSetting
     * @return \Illuminate\Http\Response
     */
    public function update(SystemSettingUpdateRequest $request, int $id)
    {
        $data = $request->all();
        $systemSettingService = new SystemSettingService();
        $systemSetting = $systemSettingService->update($data, $id);
        return (new SystemSettingResource($systemSetting))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SystemSetting  $systemSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(SystemSetting $systemSetting)
    {
        //
    }
}
