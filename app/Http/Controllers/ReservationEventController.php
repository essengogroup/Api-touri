<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationEventStoreRequest;
use App\Http\Requests\ReservationEventUpdateRequest;
use App\Http\Resources\ReservationEventCollection;
use App\Http\Resources\ReservationEventResource;
use App\Models\ReservationEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReservationEventController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $ReservationEvents = ReservationEvent::query()
            ->when($request->input('user_id'), function ($query, $userId) {
                return $query->where('user_id', $userId);
            })
            ->get();
        return $this->sendResponse(
            data: new ReservationEventCollection($ReservationEvents),
            message: 'list of ReservationEvents');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ReservationEventStoreRequest $request
     * @return JsonResponse
     */
    public function store(ReservationEventStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $ReservationEvent = ReservationEvent::query()
            ->create(
                collect($data)
                    ->toArray());
        return $this->sendResponse(
            data: new ReservationEventResource($ReservationEvent),
            message: 'ReservationEvent created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $ReservationEvent = ReservationEvent::query()
            ->find($id);
        if (!$ReservationEvent) {
            return $this->sendError(error: 'ReservationEvent not found.');
        }
        return $this->sendResponse(
            data: new ReservationEventResource($ReservationEvent),
            message: 'ReservationEvent retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ReservationEventUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ReservationEventUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $ReservationEvent = ReservationEvent::query()
            ->find($id);
        if (!$ReservationEvent) {
            return $this->sendError(error: 'ReservationEvent not found.');
        }
        $ReservationEvent->update($data);
        return $this->sendResponse(
            data: new ReservationEventResource($ReservationEvent),
            message: 'ReservationEvent updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $ReservationEvent = ReservationEvent::query()
            ->find($id);
        if (!$ReservationEvent) {
            return $this->sendError(error: 'ReservationEvent not found.');
        }
        $ReservationEvent->delete();
        return $this->sendResponse(
            data: null,
            message: 'ReservationEvent deleted successfully.');
    }

    public function acceptReservationEvent(int $id): JsonResponse
    {
        $ReservationEvent = ReservationEvent::query()
            ->find($id);
        if (!$ReservationEvent) {
            return $this->sendError(error: 'ReservationEvent not found.');
        }
        $ReservationEvent->update(['status' => 'accepted']);
        return $this->sendResponse(
            data: new ReservationEventResource($ReservationEvent),
            message: 'ReservationEvent updated successfully.');
    }

    public function rejectReservationEvent(int $id): JsonResponse
    {
        $ReservationEvent = ReservationEvent::query()
            ->find($id);
        if (!$ReservationEvent) {
            return $this->sendError(error: 'ReservationEvent not found.');
        }
        $ReservationEvent->update(['status' => 'refused']);
        return $this->sendResponse(
            data: new ReservationEventResource($ReservationEvent),
            message: 'ReservationEvent updated successfully.');
    }

    public function cancelReservationEvent(int $id): JsonResponse
    {
        $ReservationEvent = ReservationEvent::query()
            ->find($id);
        if (!$ReservationEvent) {
            return $this->sendError(error: 'ReservationEvent not found.');
        }
        $ReservationEvent->update(['status' => 'canceled']);
        return $this->sendResponse(
            data: new ReservationEventResource($ReservationEvent),
            message: 'ReservationEvent updated successfully.');
    }

    public function paidReservationEvent(int $id): JsonResponse
    {
        $ReservationEvent = ReservationEvent::query()
            ->find($id);
        if (!$ReservationEvent) {
            return $this->sendError(error: 'ReservationEvent not found.');
        }
        $ReservationEvent->update(['status' => 'paid']);
        return $this->sendResponse(
            data: new ReservationEventResource($ReservationEvent),
            message: 'ReservationEvent updated successfully.');
    }
}
