<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClosedBillingPeriodResource;
use App\Models\ClosedBillingPeriod;
use App\Services\ClosedBillingPeriodService;
use Illuminate\Http\Request;

class ClosedBillingPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $closedBillingPeriodService = new ClosedBillingPeriodService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $filters = $request->except('per_page', 'paginate');
        $closedBillingPeriods = $closedBillingPeriodService->list($isPaginated, $perPage, $filters);
        return ClosedBillingPeriodResource::collection(
            $closedBillingPeriods
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
        $closedBillingPeriodService = new ClosedBillingPeriodService();
        $closedBillingPeriod = $closedBillingPeriodService->store($request->all());
        return (new ClosedBillingPeriodResource($closedBillingPeriod))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClosedBillingPeriod  $closedBillingPeriod
     * @return \Illuminate\Http\Response
     */
    public function show(ClosedBillingPeriod $closedBillingPeriod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClosedBillingPeriod  $closedBillingPeriod
     * @return \Illuminate\Http\Response
     */
    public function edit(ClosedBillingPeriod $closedBillingPeriod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClosedBillingPeriod  $closedBillingPeriod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClosedBillingPeriod $closedBillingPeriod)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClosedBillingPeriod  $closedBillingPeriod
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClosedBillingPeriod $closedBillingPeriod)
    {
        //
    }
}
