<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuideStoreRequest;
use App\Http\Requests\GuideUpdateRequest;
use App\Http\Resources\GuideCollection;
use App\Http\Resources\GuideResource;
use App\Models\Guide;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GuideController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $guides = Guide::query()
            ->with(['raiting'])
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->get('search')}%");
            })
            ->when($request->has('raiting'), function ($query) use ($request) {
                $query->whereHas('raiting', function ($query) use ($request) {
                    $query->where('value', '>=', $request->get('raiting'));
                });
            })
            ->get();

        return $this->sendResponse(
            data: new GuideCollection($guides),
            message: 'Guides retrieved successfully.'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GuideStoreRequest $request
     * @return JsonResponse
     */
    public function store(GuideStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $guide = Guide::query()
            ->create($data);

        return $this->sendResponse(
            data: new GuideResource($guide),
            message: 'Guide created successfully.', code: 201
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
        $guide = Guide::query()
            ->with(['raiting'])
            ->find($id);
        if (!$guide) {
            return $this->sendError(
                error: 'Guide not found.',
                code: 404
            );
        }

        return $this->sendResponse(
            data: new GuideResource($guide),
            message: 'Guide retrieved successfully.'
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param GuideUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(GuideUpdateRequest $request, int $id): JsonResponse
    {
        $guide = Guide::query()
            ->find($id);
        if (!$guide) {
            return $this->sendError(
                error: 'Guide not found.',
                code: 404
            );
        }
        $data = $request->validated();
        $guide->update($data);

        return $this->sendResponse(
            data: new GuideResource($guide),
            message: 'Guide updated successfully.', code: 200
        );
    }

    public function updateImage(Request $request, int $id): JsonResponse
    {
        $guide = Guide::query()
            ->find($id);
        if (!$guide) {
            return $this->sendError(
                error: 'Guide not found.',
                code: 404
            );
        }
        $request->validate([
            'image_path' => 'required|image'
        ]);
        $guide->update([
            'image_path' => $request->image_path
        ]);

        return $this->sendResponse(
            data: new GuideResource($guide),
            message: 'Guide updated successfully.'
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
        $guide = Guide::query()
            ->find($id);
        if (!$guide) {
            return $this->sendError(
                error: 'Guide not found.',
                code: 404
            );
        }
        $guide->delete();

        return $this->sendResponse(
            data: null,
            message: 'Guide deleted successfully.', code: 200
        );
    }
}
