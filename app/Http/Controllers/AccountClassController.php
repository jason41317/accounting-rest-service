<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountClassStoreRequest;
use App\Http\Requests\AccountClassUpdateRequest;
use App\Http\Resources\AccountClassResource;
use App\Models\AccountClass;
use App\Services\AccountClassService;
use Illuminate\Http\Request;

class AccountClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $accountClassService = new AccountClassService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $accountClasses = $accountClassService->list($isPaginated, $perPage);
        return AccountClassResource::collection(
            $accountClasses
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountClassStoreRequest $request)
    {
        $accountClassService = new AccountClassService();
        $acountClass = $accountClassService->store($request->all());
        return (new AccountClassResource($acountClass))
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
        $accountClassService = new AccountClassService();
        $acountClass = $accountClassService->get($id);
        return new AccountClassResource($acountClass);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccountClassUpdateRequest $request, int $id)
    {
        $accountClassService = new AccountClassService();
        $acountClass = $accountClassService->update($request->all(), $id);

        return (new AccountClassResource($acountClass))
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
        $accountClassService = new AccountClassService();
        $accountClassService->delete($id);
        return response()->json([], 204);
    }
}
