<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessTypeStoreRequest;
use App\Http\Requests\BusinessTypeUpdateRequest;
use App\Http\Resources\BusinessTypeResource;
use App\Models\BusinessType;
use App\Services\BusinessTypeService;
use Illuminate\Http\Request;
use App\Services\BusinessTypeService;
use App\Http\Resources\BusinessTypeResource;

class BusinessTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $businessTypeService = new BusinessTypeService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $businessTypes = $businessTypeService->list($isPaginated, $perPage);
        return BusinessTypeResource::collection(
            $businessTypes
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BusinessTypeStoreRequest $request)
    {
        $businessTypeService = new BusinessTypeService();
        $businessType = $businessTypeService->store($request->all());
        return (new BusinessTypeResource($businessType))
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
        $businessTypeService = new BusinessTypeService();
        $businessType = $businessTypeService->get($id);
        return new BusinessTypeResource($businessType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BusinessTypeUpdateRequest $request, int $id)
    {
        $businessTypeService = new BusinessTypeService();
        $businessType = $businessTypeService->update($request->all(), $id);

        return (new BusinessTypeResource($businessType))
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
        $businessTypeService = new BusinessTypeService();
        $businessTypeService->delete($id);
        return response()->json([], 204);
    }
}
