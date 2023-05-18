<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddSiteToActiveRequest;
use App\Http\Requests\StoreActiviteRequest;
use App\Http\Requests\UpdateActiviteRequest;
use App\Http\Resources\ActiviteResource;
use App\Models\Activite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActiviteController extends ApiController
{
    public function addSite(AddSiteToActiveRequest $request, $id)
    {
        // TODO: check if site exists
        $activite = Activite::findOrFail($id);
        if ($activite->sites->contains($request->site_id)) {
            return response()->json([
                'message' => 'Site already exists'
            ], 409);
        }
        $activite->sites()->attach($request->site_id, [
            'type' => $request->has('type') ? $request->type : 'obligatoire',
            'price' => $request->has('type') && $request->type === 'optionnel' ? $request->price : null
        ]);
        return response()->json([
            'message' => 'Site added successfully',
            'data' => new ActiviteResource($activite)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $activite = Activite::query()
            ->orderBy('created_at', 'desc')->get();
        return $this->sendResponse(
            data: ActiviteResource::collection($activite),
            message: 'Activites retrieved successfully.'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreActiviteRequest $request
     * @return JsonResponse
     */
    public function store(StoreActiviteRequest $request): JsonResponse
    {
        $data = $request->validated();
        if ($request->hasFile('image_path')) {
            $data['image_path'] = saveFileToStorageDirectory($request, 'image_path', 'activites');
        }
        $activite = Activite::create($data);
        return $this->sendResponse(
            data: new ActiviteResource($activite),
            message: 'Activite created successfully.',
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
        $activite = Activite::query()
            ->with('sites')
            ->find($id);
        if (is_null($activite)) {
            return $this->sendError(
                error: 'Activite not found.',
                code: 404
            );
        }

        return $this->sendResponse(
            data: new ActiviteResource($activite),
            message: 'Activite retrieved successfully.'
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateActiviteRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateActiviteRequest $request, int $id): JsonResponse
    {
        $activite = Activite::query()->find($id);
        if (is_null($activite)) {
            return $this->sendError(
                error: 'Activite not found.',
                code: 404
            );
        }
        $data = $request->validated();
        if ($request->hasFile('image_path')) {
            $data['image_path'] = saveFileToStorageDirectory($request, 'image_path', 'activites');
        }
        $activite->update($data);
        return $this->sendResponse(
            data: new ActiviteResource($activite),
            message: 'Activite updated successfully.'
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
        $this->middleware('admin');

        $activite = Activite::query()->find($id);
        if (is_null($activite)) {
            return $this->sendError(
                error: 'Activite not found.',
                code: 404
            );
        }
        $activite->delete();
        return $this->sendResponse(
            data: null,
            message: 'Activite deleted successfully.'
        );
    }

    public function addSiteToActivite(int $id, int $site_id): JsonResponse
    {
        $activite = Activite::query()->find($id);
        if (is_null($activite)) {
            return $this->sendError(
                error: 'Activite not found.',
                code: 404
            );
        }
        $activite->sites()->sync($site_id);
        return $this->sendResponse(
            data: new ActiviteResource($activite),
            message: 'Site added successfully.'
        );
    }

    public function removeSiteToActivite(int $id, int $site_id): JsonResponse
    {
        $activite = Activite::query()->find($id);
        if (is_null($activite)) {
            return $this->sendError(
                error: 'Activite not found.',
                code: 404
            );
        }
        $activite->sites()->detach($site_id);
        return $this->sendResponse(
            data: new ActiviteResource($activite),
            message: 'Site removed successfully.'
        );
    }
}
