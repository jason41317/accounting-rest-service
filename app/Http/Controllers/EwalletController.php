<?php

namespace App\Http\Controllers;

use App\Models\Ewallet;
use Illuminate\Http\Request;
use App\Services\EWalletService;
use App\Http\Resources\EWalletResource;
use App\Http\Requests\EWalletStoreRequest;
use App\Http\Requests\EWalletUpdateRequest;

class EwalletController extends Controller
{
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $eWalletService = new EWalletService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $eWallets = $eWalletService->list($isPaginated, $perPage);
        return EWalletResource::collection(
            $eWallets
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EWalletStoreRequest $request)
    {
        $eWalletService = new EWalletService();
        $eWallet = $eWalletService->store($request->all());
        return (new EWalletResource($eWallet))
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
        $eWalletService = new EWalletService();
        $eWallet = $eWalletService->get($id);
        return new EWalletResource($eWallet);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EWalletUpdateRequest $request, int $id)
    {
        $eWalletService = new EWalletService();
        $eWallet = $eWalletService->update($request->all(), $id);

        return (new EWalletResource($eWallet))
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
        $eWalletService = new EWalletService();
        $eWalletService->delete($id);
        return response()->json([], 204);
    }
}
