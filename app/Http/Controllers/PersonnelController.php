<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonnelStoreRequest;
use App\Http\Requests\PersonnelUpdateRequest;
use App\Http\Resources\PersonnelResource;
use App\Models\Personnel;
use App\Services\PersonnelService;
use Illuminate\Http\Request;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $personnelService = new PersonnelService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $personnels = $personnelService->list($isPaginated, $perPage);
        return PersonnelResource::collection(
            $personnels
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PersonnelStoreRequest $request)
    {
        $personnelService = new PersonnelService();
        $data = $request->except('user');
        $user = $request->user ?? [];
        $personnel = $personnelService->store($data, $user);
        return (new PersonnelResource($personnel))
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
        $personnelService = new PersonnelService();
        $personnel = $personnelService->get($id);
        return new PersonnelResource($personnel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PersonnelUpdateRequest $request, int $id)
    {
        $personnelService = new PersonnelService();
        $data = $request->except('user');
        $user = $request->user ?? [];
        $personnel = $personnelService->update($data, $user, $id);

        return (new PersonnelResource($personnel))
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
        $personnelService = new PersonnelService();
        $personnelService->delete($id);
        return response()->json([], 204);
    }
}
