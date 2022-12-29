<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;


class MediaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
    public function index()
    {
        return MediaResource::collection(Media::paginate());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
    public function store(StoreMediaRequest $request)
    {
        $data = $request->validated();
        $data['path'] = saveFileToStorageDirectory($request, 'path', 'medias');
        $media = Media::create($data);
        return response()->json([
            'message' => 'Media created successfully',
            'media' => new MediaResource($media)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
    public function show($id)
    {
        $media = Media::findOrFail($id);
        return response()->json([
            'message' => 'Media found successfully',
            'media' => new MediaResource($media)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Media  $media
     * @return \Illuminate\Http\Response
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
    public function destroy(Media $media)
    {
        $media->delete();
        return response()->json([
            'message' => 'Media deleted successfully',
        ]);
    }
}
