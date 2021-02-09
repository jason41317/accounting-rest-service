<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessStyleStoreRequest;
use App\Http\Requests\BusinessStyleUpdateRequest;
use App\Http\Resources\BusinessStyleResource;
use App\Models\BusinessStyle;
use App\Services\BusinessStyleService;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BusinessStyleStoreRequest $request)
    {
        $businessStyleService = new BusinessStyleService();
        $businessStyle = $businessStyleService->store($request->all());
        return (new BusinessStyleResource($businessStyle))
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
        $businessStyleService = new BusinessStyleService();
        $businessStyle = $businessStyleService->get($id);
        return new BusinessStyleResource($businessStyle);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BusinessStyleUpdateRequest $request, int $id)
    {
        $businessStyleService = new BusinessStyleService();
        $businessStyle = $businessStyleService->update($request->all(), $id);

        return (new BusinessStyleResource($businessStyle))
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
        $businessStyleService = new BusinessStyleService();
        $businessStyleService->delete($id);
        return response()->json([], 204);
    }
}
