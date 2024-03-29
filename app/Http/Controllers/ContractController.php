<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractStoreRequest;
use App\Http\Requests\ContractUpdateRequest;
use App\Models\Contract;
use Illuminate\Http\Request;
use App\Services\ContractService;
use App\Http\Resources\ContractResource;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $contractService = new ContractService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $filters = $request->except('paginate', 'per_page');
        $contracts = $contractService->list($isPaginated, $perPage, $filters);
        return ContractResource::collection(
            $contracts
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContractStoreRequest $request)
    {
        $contractService = new ContractService();
        $data = $request->except(['charges', 'services']);
        $charges = $request->charges ?? [];
        $services = $request->services ?? [];
        $contract = $contractService->store($data, $services, $charges);
        return (new ContractResource($contract))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show(Int $id)
    {
        $contractService = new ContractService();
        $contract = $contractService->get($id);
        return new ContractResource($contract);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContractUpdateRequest $request, int $id)
    {
        $contractService = new ContractService();
        $data = $request->except(['charges', 'services', 'assignee']);
        $charges = $request->charges ?? [];
        $services = $request->services ?? [];
        $assignee = $request->assignee ?? null;
        $contract = $contractService->update($data, $services, $charges, $assignee, $id);
        return (new ContractResource($contract))
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
        $contractService = new ContractService();
        $contractService->delete($id);
        return response()->json([], 204); 
    }

    public function getContractHistory(int $id, Request $request)
    {
        $contractService = new ContractService();
        $filters = $request->all();
        $contractHistory = $contractService->getContractHistory($id, $filters);
        return ContractResource::collection(
            $contractHistory
        );
    }
}
