<?php

namespace App\Http\Controllers;

use App\Models\Disbursement;
use Illuminate\Http\Request;
use App\Services\DisbursementService;
use App\Http\Resources\DisbursementResource;
use App\Http\Requests\DisbursementStoreRequest;
use App\Http\Requests\DisbursementUpdateRequest;

class DisbursementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $disbursementService = new DisbursementService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $filters = $request->except(['paginate', 'per_page']);
        $disbursements = $disbursementService->list($isPaginated, $perPage, $filters);
        
        return DisbursementResource::collection(
            $disbursements
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DisbursementStoreRequest $request)
    {
        $disbursementService = new DisbursementService();
        $data = $request->except('disbursement_details');
        $disbursementDetails = $request->disbursement_details ?? [];
       
        $disbursement = $disbursementService->store($data, $disbursementDetails);
        return (new DisbursementResource($disbursement))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Disbursement  $disbursement
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $disbursementService = new DisbursementService();
        $disbursement = $disbursementService->get($id);
        return new DisbursementResource($disbursement);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Disbursement  $disbursement
     * @return \Illuminate\Http\Response
     */
    public function update(DisbursementUpdateRequest $request, int $id)
    {
        $disbursementService = new DisbursementService();
        $data = $request->except('disbursement_details');
        $disbursementDetails = $request->disbursement_details ?? [];
        $disbursement = $disbursementService->update($data, $disbursementDetails, $id);
        return (new DisbursementResource($disbursement))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Disbursement  $disbursement
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $disbursementService = new DisbursementService();
        $disbursementService->delete($id);
        return response()->json([], 204);
    }
}
