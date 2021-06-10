<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaxFundStoreRequest;
use App\Http\Requests\TaxFundUpdateRequest;
use App\Http\Resources\TaxFundResource;
use App\Models\TaxFund;
use App\Services\TaxFundService;
use Illuminate\Http\Request;

class TaxFundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $taxFundService = new TaxFundService();
        $perPage = $request->per_page ?? 20;
        $filters = $request->all();
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $taxFunds = $taxFundService->list($isPaginated, $perPage, $filters);
        return TaxFundResource::collection(
            $taxFunds
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaxFundStoreRequest $request)
    {
        $taxFundService = new TaxFundService();
        $taxFund = $taxFundService->store($request->all());
        return (new TaxFundResource($taxFund))
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
        $taxFundService = new TaxFundService();
        $taxFund = $taxFundService->get($id);
        return new TaxFundResource($taxFund);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaxFundUpdateRequest $request, int $id)
    {
        $taxFundService = new TaxFundService();
        $taxFund = $taxFundService->update($request->all(), $id);

        return (new TaxFundResource($taxFund))
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
        $taxFundService = new TaxFundService();
        $taxFundService->delete($id);
        return response()->json([], 204);
    }
}
