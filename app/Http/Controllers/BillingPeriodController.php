<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillingPeriodStoreRequest;
use App\Http\Requests\BillingPeriodUpdateRequest;
use App\Http\Resources\BillingPeriodResource;
use App\Models\BillingPeriod;
use Illuminate\Http\Request;
use App\Services\BillingPeriodService;

class BillingPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $billingPeriodService = new BillingPeriodService();
        $perPage = $request->per_page ?? 20;
        $filters = $request->all();
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $billingPeriods = $billingPeriodService->list($isPaginated, $perPage, $filters);
        return BillingPeriodResource::collection(
            $billingPeriods
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BillingPeriodStoreRequest $request)
    {
        $billingPeriodService = new BillingPeriodService();
        $billingPeriod = $billingPeriodService->store($request->all());
        return (new BillingPeriodResource($billingPeriod))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $billingPeriodService = new BillingPeriodService();
        $billingPeriod = $billingPeriodService->get($id);
        return new BillingPeriodResource($billingPeriod);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BillingPeriodUpdateRequest $request, int $id)
    {
        $billingPeriodService = new BillingPeriodService();
        $billingPeriod = $billingPeriodService->update($request->all(), $id);

        return (new BillingPeriodResource($billingPeriod))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $billingPeriodService = new BillingPeriodService();
        $billingPeriodService->delete($id);
        return response()->json([], 204);
    }
}
