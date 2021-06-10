<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreditMemoStoreRequest;
use App\Http\Requests\CreditMemoUpdateRequest;
use App\Http\Resources\ChargeResource;
use App\Http\Resources\CreditMemoResource;
use App\Models\CreditMemo;
use App\Services\CreditMemoService;
use Illuminate\Http\Request;

class CreditMemoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $creditMemoService = new CreditMemoService();
        $perPage = $request->per_page ?? 20;
        $filters = $request->all();
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $creditMemos = $creditMemoService->list($isPaginated, $perPage, $filters);
        return CreditMemoResource::collection(
            $creditMemos
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreditMemoStoreRequest $request)
    {
        $creditMemoService = new CreditMemoService();
        $data = $request->except('charges');
        $charges = $request->charges ?? [];
        $creditMemo = $creditMemoService->store($data, $charges);
        return (new CreditMemoResource($creditMemo))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Billing  $creditMemo
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $creditMemoService = new CreditMemoService();
        $creditMemo = $creditMemoService->get($id);
        return new CreditMemoResource($creditMemo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreditMemoUpdateRequest $request, int $id)
    {
        $creditMemoService = new CreditMemoService();
        $data = $request->except('charges');
        $charges = $request->charges ?? [];
        $creditMemo = $creditMemoService->update($data, $charges, $id);
        return (new CreditMemoResource($creditMemo))
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
        $creditMemoService = new CreditMemoService();
        $creditMemoService->delete($id);
        return response()->json([], 204);
    }

    public function charges(int $creditMemoId, Request $request)
    {
        $creditMemoService = new CreditMemoService();
        $filters = $request->all();
        $charges = $creditMemoService->charges($creditMemoId, $filters);
        return ChargeResource::collection(
            $charges
        );
    }
}
