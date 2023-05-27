<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $comments = Comment::query()->with('user')->get();
        return $this->sendResponse(
            data: new CommentCollection($comments),
            message: 'Comments retrieved successfully.'
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
        $comment = Comment::query()->with('user')->find($id);
        if (is_null($comment)) {
            return $this->sendError('Comment not found.');
        }
        return $this->sendResponse(
            data: new CommentResource($comment),
            message: 'Comment retrieved successfully.'
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'comment' => 'required|string',
        ]);
        $comment = Comment::query()->find($id);
        if (is_null($comment)) {
            return $this->sendError('Comment not found.');
        }
        $data = $request->all();
        $comment->update($data);
        return $this->sendResponse(
            data: new CommentResource($comment),
            message: 'Comment updated successfully.'
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
        $comment = Comment::query()->find($id);
        if (is_null($comment)) {
            return $this->sendError('Comment not found.');
        }
        $comment->delete();
        return $this->sendResponse(
            data: null,
            message: 'Comment deleted successfully.'
        );
    }
}
