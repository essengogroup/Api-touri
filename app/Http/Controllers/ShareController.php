<?php

namespace App\Http\Controllers;

use App\Models\Share;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShareController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $shares = Share::query()
            ->with('user')
            ->with('shareable')
            ->get();
        return $this->sendResponse(
            data: $shares,
            message: "Shares retrieved successfully"
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|integer',
            'shareable_id' => 'required|integer',
            'shareable_type' => 'required|string',
        ]);
        $share = Share::query()->create($request->all());
        return $this->sendResponse(
            data: $share,
            message: "Share created successfully"
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
        $share = Share::query()->find($id);
        if (!$share) {
            return $this->sendError(
                error: "Share not found"
            );
        }
        return $this->sendResponse(
            data: $share,
            message: "Share retrieved successfully"
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
        $share = Share::query()->find($id);
        if (!$share) {
            return $this->sendError(
                error: "Share not found"
            );
        }
        $share->delete();
        return $this->sendResponse(
            data: null,
            message: "Share deleted successfully"
        );
    }
}
