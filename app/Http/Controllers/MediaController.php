<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{

    public function index()
    {
        return MediaResource::collection(Media::paginate());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     */
    public function destroy(Media $media)
    {
        $media->delete();
        return response()->json([
            'message' => 'Media deleted successfully',
        ]);
    }
}
