<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddSiteToActiveRequest;
use App\Http\Requests\StoreSiteRequest;
use App\Http\Requests\UpdateSiteRequest;
use App\Http\Resources\SiteResource;
use App\Models\Site;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SitesController extends ApiController
{
    /**
     * Display the specified resource.
     *
     * @param AddSiteToActiveRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function addActivite(AddSiteToActiveRequest $request, int $id): JsonResponse
    {
        // TODO: check if activite exists
        $site = Site::findOrFail($id);
        if ($site->activites->contains($request->activite_id)) {
            return response()->json([
                'message' => 'Activite already exists'
            ], 409);
        }
        $site->activites()->attach($request->activite_id, [
            'type' => $request->has('type') ? $request->type : 'obligatoire',
            'price' => $request->has('type') && $request->type === 'optionnel' ? $request->price : null
        ]);
        return response()->json([
            'message' => 'Activite added successfully',
            'data' => new SiteResource($site)
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $sites = Site::query()
            ->with(['departement', 'medias', 'comments', 'activites'])
            ->when($request->has('name'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%');
            })
            ->when($request->has('price'), function ($query) use ($request) {
                $query->where('price', $request->price);
            })
            ->when($request->has('sort'), function ($query) use ($request) {
                $query->orderBy($request->sort, $request->has('order') ? $request->order : 'asc');
            })->get();
//            ->paginate($request->has('per_page') ? $request->per_page : 10);
//        return $this->respondWithPagination($sites, new SiteResource($sites));
        return $this->sendResponse(
            data: SiteResource::collection($sites),
            message: 'Sites retrieved successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSiteRequest $request
     * @return JsonResponse
     */
    public function store(StoreSiteRequest $request): JsonResponse
    {
        $this->middleware('admin');
        $data = $request->validated();
        $site = Site::create($data);
        return $this->sendResponse(
            data: new SiteResource($site),
            message: 'Site created successfully',
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
        $site = Site::query()
            ->with(['activites', 'departement', 'medias', 'comments', 'likes', 'guides', 'restaurants', 'transports', 'hebergements', 'assurances'])
            ->find($id);
        if (!$site) {
            return $this->sendError(
                error: 'Site not found',
                code: 404
            );
        }
        return $this->sendResponse(
            data: new SiteResource($site),
            message: 'Site retrieved successfully',
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSiteRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateSiteRequest $request, int $id): JsonResponse
    {
        $this->middleware('admin');
        $site = Site::query()->find($id);
        if (!$site) {
            return $this->sendError(
                error: 'Site not found',
                code: 404
            );
        }
        $data = $request->validated();
        $site->update($data);
        return $this->sendResponse(
            data: new SiteResource($site),
            message: 'Site updated successfully',
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
        $site = Site::query()->find($id);
        if (!$site) {
            return $this->sendError(
                error: 'Site not found',
                code: 404
            );
        }
        $site->delete();
        return $this->sendResponse(
            data: null,
            message: 'Site deleted successfully',
        );
    }

    public function removeActivite(int $id, int $activite_id): JsonResponse
    {
        // TODO: check if activite exists
        $site = Site::query()->find($id);
        if (!$site || !$site->activites->contains($activite_id)) {
            return $this->sendError(
                error: 'Site not found',
                code: 404
            );
        }
        $site->activites()->detach($activite_id);
        return $this->sendResponse(
            data: new SiteResource($site),
            message: 'Activite removed successfully',
        );
    }

    public function addActiviteToSite(int $id, int $activite_id): JsonResponse
    {
        $site = Site::query()->find($id);
        if (!$site) {
            return $this->sendError(
                error: 'Site not found',
                code: 404
            );
        }
        $site->activites()->attach($activite_id);
        return $this->sendResponse(
            data: new SiteResource($site),
            message: 'Activite added successfully',
        );
    }

    public function updateActiviteToSite(AddSiteToActiveRequest $request, $id, $activite_id)
    {
        // TODO: check if activite exists
        $site = Site::findOrFail($id);
        if (!$site->activites->contains($activite_id)) {
            return response()->json([
                'message' => 'Activite does not exists'
            ], 409);
        }
        $site->activites()->updateExistingPivot($activite_id, [
            'type' => $request->has('type') ? $request->type : 'obligatoire',
            'price' => $request->has('type') && $request->type === 'optionnel' ? $request->price : null
        ]);
        return response()->json([
            'message' => 'Activite updated successfully',
            'data' => new SiteResource($site)
        ]);
    }

}
