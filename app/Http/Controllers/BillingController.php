<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillingStoreRequest;
use App\Models\Billing;
use Illuminate\Http\Request;
use App\Services\BillingService;
use App\Http\Resources\BillingResource;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $billingService = new BillingService();
        $perPage = $request->per_page ?? 20;
        $filters = $request->all();
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $billings = $billingService->list($isPaginated, $perPage, $filters);
        return BillingResource::collection(
            $billings
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $billingService = new BillingService();
        $data = $request->except('charges','adjustmentCharges');
        $charges = $request->charges ?? [];
        $adjustmentCharges = $request->adjustment_charges ?? [];
        $billing = $billingService->store($data, $charges, $adjustmentCharges);
        return (new BillingResource($billing))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $billingService = new BillingService();
        $billing = $billingService->get($id);
        return new BillingResource($billing);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function edit(Billing $billing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Billing $billing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Billing $billing)
    {
        //
    }
}
