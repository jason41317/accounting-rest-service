<?php

namespace App\Http\Controllers;

use App\Http\Requests\RdoStoreRequest;
use App\Http\Requests\RdoUpdateRequest;
use App\Http\Resources\RdoResource;
use App\Models\Rdo;
use App\Services\RdoService;
use Illuminate\Http\Request;

class RdoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rdoService = new RdoService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $rdos = $rdoService->list($isPaginated, $perPage);
        return RdoResource::collection(
            $rdos
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RdoStoreRequest $request)
    {
        $rdoService = new RdoService();
        $rdo = $rdoService->store($request->all());
        return (new RdoResource($rdo))
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
        $rdoService = new RdoService();
        $rdo = $rdoService->get($id);
        return new RdoResource($rdo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RdoUpdateRequest $request, int $id)
    {
        $rdoService = new RdoService();
        $rdo = $rdoService->update($request->all(), $id);

        return (new RdoResource($rdo))
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
        $rdoService = new RdoService();
        $rdoService->delete($id);
        return response()->json([], 204);
    }
}