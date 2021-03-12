<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaxTypeStoreRequest;
use App\Http\Requests\TaxTypeUpdateRequest;
use App\Http\Resources\TaxTypeResource;
use App\Models\TaxType;
use App\Services\TaxTypeService;
use Illuminate\Http\Request;

class TaxTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $taxTypeService = new TaxTypeService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $taxTypes = $taxTypeService->list($isPaginated, $perPage);
        return TaxTypeResource::collection(
            $taxTypes
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaxTypeStoreRequest $request)
    {
        $taxTypeService = new TaxTypeService();
        $taxType = $taxTypeService->store($request->all());
        return (new TaxTypeResource($taxType))
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
        $taxTypeService = new TaxTypeService();
        $taxType = $taxTypeService->get($id);
        return new TaxTypeResource($taxType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaxTypeUpdateRequest $request, int $id)
    {
        $taxTypeService = new TaxTypeService();
        $taxType = $taxTypeService->update($request->all(), $id);

        return (new TaxTypeResource($taxType))
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
        $taxTypeService = new TaxTypeService();
        $taxTypeService->delete($id);
        return response()->json([], 204);
    }
}
