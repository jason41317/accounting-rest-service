<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessStyle;
use App\Services\BusinessStyleService;
use App\Http\Resources\BusinessStyleResource;

class BusinessStyleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $businessStyleService = new BusinessStyleService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $businessStyles = $businessStyleService->list($isPaginated, $perPage);
        return BusinessStyleResource::collection(
            $businessStyles
        );
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
     * @param  \App\Models\BusinessStyle  $businessStyle
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessStyle $businessStyle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BusinessStyle  $businessStyle
     * @return \Illuminate\Http\Response
     */
    public function edit(BusinessStyle $businessStyle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BusinessStyle  $businessStyle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusinessStyle $businessStyle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BusinessStyle  $businessStyle
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessStyle $businessStyle)
    {
        //
    }
}
