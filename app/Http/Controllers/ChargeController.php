<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChargeStoreRequest;
use App\Http\Requests\ChargeUpdateRequest;
use App\Models\Charge;
use Illuminate\Http\Request;
use App\Services\ChargeService;
use App\Http\Resources\ChargeResource;

class ChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $chargeService = new ChargeService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $charges = $chargeService->list($isPaginated, $perPage);
        return ChargeResource::collection(
            $charges
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChargeStoreRequest $request)
    {
        $chargeService = new ChargeService();
        $charge = $chargeService->store($request->all());
        return (new ChargeResource($charge))
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
        $chargeService = new ChargeService();
        $charge = $chargeService->get($id);
        return new ChargeResource($charge);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ChargeUpdateRequest $request, int $id)
    {
        $chargeService = new ChargeService();
        $charge = $chargeService->update($request->all(), $id);

        return (new ChargeResource($charge))
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
        $chargeService = new ChargeService();
        $chargeService->delete($id);
        return response()->json([], 204);
    }
}
