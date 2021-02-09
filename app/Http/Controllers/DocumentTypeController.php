<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentTypeStoreRequest;
use App\Http\Requests\DocumentTypeUpdateRequest;
use App\Http\Resources\DocumentTypeResource;
use App\Models\DocumentType;
use App\Services\DocumentTypeService;
use Illuminate\Http\Request;

class DocumentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $documentTypeService = new DocumentTypeService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $documentTypes = $documentTypeService->list($isPaginated, $perPage);
        return DocumentTypeResource::collection(
            $documentTypes
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentTypeStoreRequest $request)
    {
        $documentTypeService = new DocumentTypeService();
        $documentType = $documentTypeService->store($request->all());
        return (new DocumentTypeResource($documentType))
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
        $documentTypeService = new DocumentTypeService();
        $documentType = $documentTypeService->get($id);
        return new DocumentTypeResource($documentType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentTypeUpdateRequest $request, int $id)
    {
        $documentTypeService = new DocumentTypeService();
        $documentType = $documentTypeService->update($request->all(), $id);

        return (new DocumentTypeResource($documentType))
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
        $documentTypeService = new DocumentTypeService();
        $documentTypeService->delete($id);
        return response()->json([], 204);
    }
}
