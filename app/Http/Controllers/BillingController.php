<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillingStoreRequest;
use App\Http\Requests\BillingUpdateRequest;
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
    public function store(BillingStoreRequest $request)
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BillingUpdateRequest $request, int $id)
    {
        $billingService = new BillingService();
        $data = $request->except('charges', 'adjustmentCharges');
        $charges = $request->charges ?? [];
        $adjustmentCharges = $request->adjustment_charges ?? [];
        $billing = $billingService->update($data, $charges, $adjustmentCharges, $id);
        return (new BillingResource($billing))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $billingService = new BillingService();
        $billingService->delete($id);
        return response()->json([], 204);
    }

    public function batchStore(Request $request) 
    {
        $billingService = new BillingService();
        $data = $request->all();
        $billings = $billingService->batchStore($data);
        return $billings;
    }
}
