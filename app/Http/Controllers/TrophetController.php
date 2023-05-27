<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrophetStoreRequest;
use App\Http\Requests\TrophetUpdateRequest;
use App\Http\Resources\TrophetCollection;
use App\Http\Resources\TrophetResource;
use App\Models\Trophet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrophetController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $trophets = Trophet::query()
            ->with('users')
            ->when($request->input('user_id'), function ($query, $userId) {
                return $query->where('user_id', $userId);
            })
            ->get();

        return $this->sendResponse(
            data: new TrophetCollection($trophets),
            message: 'Trophets retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TrophetStoreRequest $request
     * @return JsonResponse
     */
    public function store(TrophetStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $trophets = Trophet::query()
            ->create(collect($data)
                ->only(['name', 'description', 'image_path'])->toArray());

        return $this->sendResponse(
            data: new TrophetCollection($trophets),
            message: 'Trophets created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $trophet = Trophet::query()
            ->find($id);
        if (is_null($trophet)) {
            return $this->sendError(
                error: 'Trophets not found.');
        }
        return $this->sendResponse(
            data: new TrophetResource($trophet),
            message: 'Trophets retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TrophetUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(TrophetUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $trophet = Trophet::query()
            ->find($id);
        if (is_null($trophet)) {
            return $this->sendError(
                error: 'Trophets not found.');
        }
        $trophet->update(collect($data)
            ->only(['name', 'description'])->toArray());

        return $this->sendResponse(
            data: new TrophetResource($trophet),
            message: 'Trophets updated successfully.');
    }

    public function updateImage(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $trophet = Trophet::query()
            ->find($id);
        if (is_null($trophet)) {
            return $this->sendError(
                error: 'Trophets not found.');
        }
        $trophet->update(['image_path' => saveFileToStorageDirectory($request, 'trophet', 'trophet')]);

        return $this->sendResponse(
            data: new TrophetResource($trophet),
            message: 'Trophets updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $trophet = Trophet::query()
            ->find($id);
        if (is_null($trophet)) {
            return $this->sendError(
                error: 'Trophets not found.');
        }
        $trophet->delete();

        return $this->sendResponse(
            data: new TrophetResource($trophet),
            message: 'Trophets deleted successfully.');
    }
}
