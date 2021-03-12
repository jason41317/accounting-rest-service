<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceCategoryStoreRequest;
use App\Http\Requests\ServiceCategoryUpdateRequest;
use App\Http\Resources\ServiceCategoryResource;
use App\Services\ServiceCategoryService;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $serviceCategoryService = new ServiceCategoryService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $serviceCategories = $serviceCategoryService->list($isPaginated, $perPage);
        return ServiceCategoryResource::collection(
            $serviceCategories
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceCategoryStoreRequest $request)
    {
        $serviceCategoryService = new ServiceCategoryService();
        $serviceCategory = $serviceCategoryService->store($request->all());
        return (new ServiceCategoryResource($serviceCategory))
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
        $serviceCategoryService = new ServiceCategoryService();
        $serviceCategory = $serviceCategoryService->get($id);
        return new ServiceCategoryResource($serviceCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceCategoryUpdateRequest $request, int $id)
    {
        $serviceCategoryService = new ServiceCategoryService();
        $serviceCategory = $serviceCategoryService->update($request->all(), $id);

        return (new ServiceCategoryResource($serviceCategory))
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
        $serviceCategoryService = new ServiceCategoryService();
        $serviceCategoryService->delete($id);
        return response()->json([], 204);
    }
}
