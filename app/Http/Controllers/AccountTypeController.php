<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountTypeStoreRequest;
use App\Http\Requests\AccountTypeUpdateRequest;
use App\Http\Resources\AccountTypeResource;
use App\Models\AccountType;
use App\Services\AccountTypeService;
use Illuminate\Http\Request;

class AccountTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $accountTypeService = new AccountTypeService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $accountTypes = $accountTypeService->list($isPaginated, $perPage);
        return AccountTypeResource::collection(
            $accountTypes
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountTypeStoreRequest $request)
    {
        $accountTypeService = new AccountTypeService();
        $accountType = $accountTypeService->store($request->all());
        return (new AccountTypeResource($accountType))
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
        $accountTypeService = new AccountTypeService();
        $accountType = $accountTypeService->get($id);
        return new AccountTypeResource($accountType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccountTypeUpdateRequest $request, int $id)
    {
        $accountTypeService = new AccountTypeService();
        $accountType = $accountTypeService->update($request->all(), $id);

        return (new AccountTypeResource($accountType))
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
        $accountTypeService = new AccountTypeService();
        $accountTypeService->delete($id);
        return response()->json([], 204);
    }
}
