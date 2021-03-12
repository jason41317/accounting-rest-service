<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountTitleStoreRequest;
use App\Http\Requests\AccountTitleUpdateRequest;
use App\Http\Resources\AccountTitleResource;
use App\Models\AccountTitle;
use App\Services\AccountTitleService;
use Illuminate\Http\Request;

class AccountTitleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $accountTitleService = new AccountTitleService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $accountTitles = $accountTitleService->list($isPaginated, $perPage);
        return AccountTitleResource::collection(
            $accountTitles
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountTitleStoreRequest $request)
    {
        $accountTitleService = new AccountTitleService();
        $accountTitle = $accountTitleService->store($request->all());
        return (new AccountTitleResource($accountTitle))
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
        $accountTitleService = new AccountTitleService();
        $accountTitle = $accountTitleService->get($id);
        return new AccountTitleResource($accountTitle);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccountTitleUpdateRequest $request, int $id)
    {
        $accountTitleService = new AccountTitleService();
        $accountTitle = $accountTitleService->update($request->all(), $id);

        return (new AccountTitleResource($accountTitle))
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
        $accountTitleService = new AccountTitleService();
        $accountTitleService->delete($id);
        return response()->json([], 204);
    }
}
