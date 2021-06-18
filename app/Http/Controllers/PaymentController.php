<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentStoreRequest;
use App\Http\Requests\PaymentUpdateRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paymentService = new PaymentService();
        $perPage = $request->per_page ?? 20;
        $filters = $request->all();
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $payments = $paymentService->list($isPaginated, $perPage, $filters);
        return PaymentResource::collection(
            $payments
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentStoreRequest $request)
    {
        $paymentService = new PaymentService();
        $data = $request->except('charges');
        $charges = $request->charges ?? [];
        $payment = $paymentService->store($data, $charges);
        return (new PaymentResource($payment))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Billing  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $paymentService = new PaymentService();
        $payment = $paymentService->get($id);
        return new PaymentResource($payment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentUpdateRequest $request, int $id)
    {
        $paymentService = new PaymentService();
        $data = $request->except('charges');
        $charges = $request->charges ?? [];
        $payment = $paymentService->update($data, $charges, $id);
        return (new PaymentResource($payment))
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
        $paymentService = new PaymentService();
        $paymentService->delete($id);
        return response()->json([], 204);
    }

    public function yearlyComparison(Request $request)
    {
        $filters = $request->all();
        $paymentService = new PaymentService();
        $payments = $paymentService->yearlyComparison($filters);
        return $payments;
    }

    public function collectionBreakdown(Request $request)
    {
        $filters = $request->all();
        $paymentService = new PaymentService();
        $payments = $paymentService->collectionBreakdown($filters);
        return $payments;
    }
}
