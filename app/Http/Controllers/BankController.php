<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Services\BankService;
use App\Http\Resources\BankResource;
use App\Http\Requests\BankStoreRequest;
use App\Http\Requests\BankUpdateRequest;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $bankService = new BankService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $banks = $bankService->list($isPaginated, $perPage);
        return BankResource::collection(
            $banks
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankStoreRequest $request)
    {
        $bankService = new BankService();
        $bank = $bankService->store($request->all());
        return (new BankResource($bank))
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
        $bankService = new BankService();
        $bank = $bankService->get($id);
        return new BankResource($bank);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BankUpdateRequest $request, int $id)
    {
        $bankService = new BankService();
        $bank = $bankService->update($request->all(), $id);

        return (new BankResource($bank))
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
        $bankService = new BankService();
        $bankService->delete($id);
        return response()->json([], 204);
    }
}
