<?php

namespace App\Http\Controllers;

use App\Http\Requests\HebergementStoreRequest;
use App\Http\Requests\HebergementUpdateRequest;
use App\Http\Resources\HebergementResource;
use App\Models\Hebergement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HebergementController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $hebergements = Hebergement::query()
            ->with('sites')
            ->get();

        return $this->sendResponse(
            data: new HebergementController($hebergements),
            message: 'Hebergements retrieved successfully.'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param HebergementStoreRequest $request
     * @return JsonResponse
     */
    public function store(HebergementStoreRequest $request): JsonResponse
    {
        $hebergement = Hebergement::query()
            ->create($request->validated());

        return $this->sendResponse(
            data: new HebergementController($hebergement),
            message: 'Hebergement created successfully.',
            code: 201
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $hebergement = Hebergement::query()
            ->with('sites')
            ->find($id);
        if (!$hebergement) {
            return $this->sendError('Hebergement not found.');
        }
        return $this->sendResponse(
            data: new HebergementResource($hebergement),
            message: 'Hebergement retrieved successfully.'
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param HebergementUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(HebergementUpdateRequest $request, int $id): JsonResponse
    {
        $hebergement = Hebergement::query()
            ->find($id);
        if (!$hebergement) {
            return $this->sendError('Hebergement not found.');
        }
        $hebergement->update($request->validated());
        return $this->sendResponse(
            data: new HebergementResource($hebergement),
            message: 'Hebergement updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $hebergement = Hebergement::query()
            ->find($id);
        if (!$hebergement) {
            return $this->sendError('Hebergement not found.');
        }
        $hebergement->delete();
        return $this->sendResponse(
            data: null,
            message: 'Hebergement deleted successfully.'
        );
    }
}
