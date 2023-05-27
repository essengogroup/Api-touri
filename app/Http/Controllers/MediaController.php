<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class MediaController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @OA\Get(
     * path="/medias",
     * summary="Get list of medias",
     * description="Returns list of medias",
     * operationId="getMediasList",
     * tags={"Medias"},
     * @OA\Response(
     *   response=200,
     *  description="Successful operation",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(ref="#/components/schemas/Media")
     * ),
     * ),
     * @OA\Response(
     * response="default",
     * description="unexpected error",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Unexpected error")
     * )
     * )
     * )
     *
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'in:image,video',
        ]);
        $medias = Media::query()
            ->when($request->has('type'), fn($query) => $query->where('type', $request->get('type'))
                ->orderBy('created_at', 'desc')
                ->get())
            ->when(!$request->has('type'), fn($query) => $query->orderBy('created_at', 'desc')
                ->get());
        return $this->sendResponse(
            data: MediaResource::collection($medias),
            message: 'list of medias');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMediaRequest $request
     * @return JsonResponse
     *
     * @OA\Post(
     * path="/medias",
     * summary="Store new media",
     * description="Returns media data",
     * operationId="storeMedia",
     * tags={"Medias"},
     * @OA\RequestBody(
     *   required=true,
     *  @OA\JsonContent(
     * required={"path"},
     * @OA\Property(property="path", type="string", format="binary"),
     * ),
     * ),
     * @OA\Response(
     * response=200,
     * description="Successful operation",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Media created successfully"),
     * @OA\Property(property="media", ref="#/components/schemas/Media"),
     * ),
     * ),
     * @OA\Response(
     * response="default",
     * description="unexpected error",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Unexpected error")
     * )
     * )
     * )
     */
    public function store(StoreMediaRequest $request): JsonResponse
    {
        $data = $request->validated();
        if ($request->hasFile('path')) {
            $data['path'] = saveFileToStorageDirectory($request, 'path', 'medias');
        }
        $media = Media::create($data);
        return $this->sendResponse(
            data: new MediaResource($media),
            message: 'Media created successfully', code: 201);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Get(
     * path="/medias/{id}",
     * summary="Get media information",
     * description="Returns media data",
     * operationId="getMediaById",
     * tags={"Medias"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID of media to return",
     * required=true,
     * @OA\Schema(
     * type="integer",
     * format="int64"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Successful operation",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Media found successfully"),
     * @OA\Property(property="media", ref="#/components/schemas/Media"),
     * ),
     * ),
     * @OA\Response(
     * response="default",
     * description="unexpected error",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Unexpected error")
     * )
     * )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $media = Media::query()->find($id);
        if (!$media) {
            return $this->sendError('Media not found');
        }
        return $this->sendResponse(
            data: new MediaResource($media),
            message: 'Media found successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Delete(
     * path="/medias/{id}",
     * summary="Delete existing media",
     * description="Deletes a record and returns no content",
     * operationId="deleteMedia",
     * tags={"Medias"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID of media to delete",
     * required=true,
     * @OA\Schema(
     * type="integer",
     * format="int64"
     * )
     * ),
     * @OA\Response(
     * response=204,
     * description="Successful operation",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Media deleted successfully"),
     * ),
     * ),
     * @OA\Response(
     * response="default",
     * description="unexpected error",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Unexpected error")
     * )
     * )
     * )
     *
     */
    public function destroy(int $id): JsonResponse
    {
        $this->middleware('admin');
        $media = Media::query()->find($id);
        if (!$media) {
            return $this->sendError('Media not found');
        }
        $media->delete();
        return $this->sendResponse(
            data: null,
            message: 'Media deleted successfully');
    }
}
