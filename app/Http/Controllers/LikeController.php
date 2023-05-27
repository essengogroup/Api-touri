<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikeController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $likes = Like::query()->get();
        return $this->sendResponse(
            data: $likes,
            message: "Likes retrieved successfully"
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
        $like = Like::query()->find($id);
        if (!$like) {
            return $this->sendError(
                error: "Like not found"
            );
        }
        return $this->sendResponse(
            data: $like,
            message: "Like retrieved successfully"
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
        $like = Like::query()->find($id);
        if (!$like) {
            return $this->sendError(
                error: "Like not found"
            );
        }
        $like->delete();
        return $this->sendResponse(
            data: null,
            message: "Like deleted successfully"
        );
    }
}
