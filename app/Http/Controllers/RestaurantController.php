<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantStoreRequest;
use App\Http\Requests\RestaurantUpdateRequest;
use App\Http\Resources\RestaurantCollection;
use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RestaurantController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $restaurants = Restaurant::query()
            ->with('sites')
            ->get();

        return $this->sendResponse(
            data: new RestaurantCollection($restaurants),
            message: 'Restaurants retrieved successfully.'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RestaurantStoreRequest $request
     * @return JsonResponse
     */
    public function store(RestaurantStoreRequest $request): JsonResponse
    {
        $restaurant = Restaurant::query()
            ->create($request->validated());

        return $this->sendResponse(
            data: new RestaurantResource($restaurant),
            message: 'Restaurant created successfully.'
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
        $restaurant = Restaurant::query()
            ->with('sites')
            ->find($id);

        if (!$restaurant) {
            return $this->sendError(
                error: 'Restaurant not found.'
            );
        }

        return $this->sendResponse(
            data: new RestaurantResource($restaurant),
            message: 'Restaurant retrieved successfully.'
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RestaurantUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(RestaurantUpdateRequest $request, int $id): JsonResponse
    {
        $restaurant = Restaurant::query()
            ->find($id);

        if (!$restaurant) {
            return $this->sendError(
                error: 'Restaurant not found.'
            );
        }

        $restaurant->update($request->validated());

        return $this->sendResponse(
            data: new RestaurantResource($restaurant),
            message: 'Restaurant updated successfully.'
        );
    }

    /**
     * Update the specified resource's image in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateImage(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $restaurant = Restaurant::query()
            ->find($id);
        if (!$restaurant) {
            return $this->sendError(
                error: 'Restaurant not found.'
            );
        }
        $imagePath = saveFileToStorageDirectory($request, 'image_path', 'restaurants');
        $restaurant->update([
            'image_path' => $imagePath
        ]);

        return $this->sendResponse(
            data: new RestaurantResource($restaurant),
            message: 'Restaurant image updated successfully.'
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
        $restaurant = Restaurant::query()
            ->find($id);

        if (!$restaurant) {
            return $this->sendError(
                error: 'Restaurant not found.'
            );
        }

        $restaurant->delete();

        return $this->sendResponse(
            data: null,
            message: 'Restaurant deleted successfully.'
        );
    }
}
