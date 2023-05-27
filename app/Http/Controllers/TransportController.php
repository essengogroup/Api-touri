<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransportStoreRequest;
use App\Http\Requests\TransportUpdateRequest;
use App\Http\Resources\TransportCollection;
use App\Http\Resources\TransportResource;
use App\Models\Transport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransportController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $transports = Transport::query()
            ->where('is_available', true)
            ->get();

        return $this->sendResponse(
            data: new TransportCollection($transports),
            message: 'Transports retrieved successfully.'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TransportStoreRequest $request
     * @return JsonResponse
     */
    public function store(TransportStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $transport = Transport::query()
            ->create($data);

        return $this->sendResponse(
            data: new TransportResource($transport),
            message: 'Transport created successfully.',
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
        $transport = Transport::query()
            ->find($id);
        if (!$transport) {
            return $this->sendError(
                error: 'Transport not found.',
            );
        }
        return $this->sendResponse(
            data: new TransportResource($transport),
            message: 'Transport retrieved successfully.'
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TransportUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(TransportUpdateRequest $request, int $id): JsonResponse
    {
        $transport = Transport::query()
            ->find($id);
        if (!$transport) {
            return $this->sendError(
                error: 'Transport not found.',
            );
        }
        $data = $request->validated();
        $transport->update($data);
        return $this->sendResponse(
            data: new TransportResource($transport),
            message: 'Transport updated successfully.'
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
        $transport = Transport::query()
            ->find($id);
        if (!$transport) {
            return $this->sendError(
                error: 'Transport not found.',
            );
        }
        $transport->delete();
        return $this->sendResponse(
            data: null,
            message: 'Transport deleted successfully.'
        );
    }
}
