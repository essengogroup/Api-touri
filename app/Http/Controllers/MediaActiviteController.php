<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaActiviteStoreRequest;
use App\Http\Resources\MediaActiviteCollection;
use App\Models\MediaActivite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MediaActiviteController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $mediaActivites = MediaActivite::query()
            ->when($request->has('activite_id'), function ($query) use ($request) {
                $query->where('activite_id', $request->activite_id);
            })
            ->orderBy('created_at', 'desc')->get();

        return $this->sendResponse(
            data: new MediaActiviteCollection($mediaActivites),
            message: 'MediaActivites retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MediaActiviteStoreRequest $request
     * @return JsonResponse
     */
    public function store(MediaActiviteStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        if ($request->hasFile('image_path')) {
            $data['path'] = saveFileToStorageDirectory($request, 'image_path', 'media_activites');
        }
        $data['type'] = $request->has('type') ? $request->type : 'image';
        $data['is_main'] = $request->has('is_main') ? $request->is_main : false;
        $mediaActivite = MediaActivite::create($data);
        return $this->sendResponse(
            data: $mediaActivite,
            message: 'MediaActivite created successfully.',
            code: 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $mediaActivite = MediaActivite::query()
            ->find($id);
        if (is_null($mediaActivite)) {
            return $this->sendError(
                error: 'MediaActivite not found.',
                code: 404
            );
        }

        return $this->sendResponse(
            data: $mediaActivite,
            message: 'MediaActivite retrieved successfully.'
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
        $mediaActivite = MediaActivite::query()
            ->find($id);
        if (is_null($mediaActivite)) {
            return $this->sendError(
                error: 'MediaActivite not found.',
                code: 404
            );
        }
        $mediaActivite->delete();
        return $this->sendResponse(
            data: null,
            message: 'MediaActivite deleted successfully.'
        );
    }
}
