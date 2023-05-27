<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssuranceStoreRequest;
use App\Http\Requests\AssuranceUpdateRequest;
use App\Http\Resources\AssuranceCollection;
use App\Http\Resources\AssuranceResource;
use App\Models\Assurance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssuranceController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $assurances = Assurance::query()
            ->with('sites')
            ->get();

        return $this->sendResponse(
            data: new AssuranceCollection($assurances),
            message: 'Assurances retrieved successfully.'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AssuranceStoreRequest $request
     * @return JsonResponse
     */
    public function store(AssuranceStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['image_path'] = $request->file('image_path')->store('assurances', 'public');
        $assurance = Assurance::query()
            ->create($data);

        return $this->sendResponse(
            data: new AssuranceResource($assurance),
            message: 'Assurance created successfully.'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $assurance = Assurance::query()
            ->with('sites')
            ->find($id);
        if (!$assurance)
            return $this->sendError(error: 'Assurance not found.');

        return $this->sendResponse(
            data: new AssuranceResource($assurance),
            message: 'Assurance retrieved successfully.'
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AssuranceUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(AssuranceUpdateRequest $request, int $id): JsonResponse
    {
        $assurance = Assurance::query()
            ->find($id);
        if (!$assurance)
            return $this->sendError(error: 'Assurance not found.');
        $data = $request->validated();

        $assurance->update($data);

        return $this->sendResponse(
            data: new AssuranceResource($assurance),
            message: 'Assurance updated successfully.'
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
        $assurance = Assurance::query()
            ->find($id);
        if (!$assurance)
            return $this->sendError(error: 'Assurance not found.');

        $assurance->delete();

        return $this->sendResponse(
            data: null,
            message: 'Assurance deleted successfully.'
        );
    }
}
