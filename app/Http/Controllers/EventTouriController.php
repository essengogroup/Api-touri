<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventTouriStoreRequest;
use App\Http\Requests\EventTouriUpdateRequest;
use App\Http\Resources\EventTouriCollection;
use App\Http\Resources\EventTouriResource;
use App\Models\EventTouri;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventTouriController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $eventTouris = EventTouri::query()
            ->get();

        return $this->sendResponse(
            data: new EventTouriCollection($eventTouris),
            message: 'Event Touris retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EventTouriStoreRequest $request
     * @return JsonResponse
     */
    public function store(EventTouriStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['image_path'] = saveFileToStorageDirectory($request, 'image_path', 'eventTouris');
        $eventTouri = EventTouri::create($data);

        return $this->sendResponse(
            data: new EventTouriResource($eventTouri),
            message: 'Event Touri created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $eventTouri = EventTouri::query()
            ->find($id);
        if (is_null($eventTouri)) {
            return $this->sendError(
                error: 'Event Touri not found.');
        }
        return $this->sendResponse(
            data: new EventTouriResource($eventTouri),
            message: 'Event Touri retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EventTouriUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(EventTouriUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $eventTouri = EventTouri::query()
            ->find($id);
        if (is_null($eventTouri)) {
            return $this->sendError(
                error: 'Event Touri not found.');
        }
        $eventTouri->update($data);
        return $this->sendResponse(
            data: new EventTouriResource($eventTouri),
            message: 'Event Touri updated successfully.');
    }

    public function updateImage(Request $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $data['image_path'] = saveFileToStorageDirectory($request, 'image_path', 'eventTouris');
        $eventTouri = EventTouri::query()
            ->find($id);
        if (is_null($eventTouri)) {
            return $this->sendError(
                error: 'Event Touri not found.');
        }
        $eventTouri->update($data);
        return $this->sendResponse(
            data: new EventTouriResource($eventTouri),
            message: 'Event Touri updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $eventTouri = EventTouri::query()
            ->find($id);
        if (is_null($eventTouri)) {
            return $this->sendError(
                error: 'Event Touri not found.');
        }
        $eventTouri->delete();
        return $this->sendResponse(
            data: null,
            message: 'Event Touri deleted successfully.');
    }
}
