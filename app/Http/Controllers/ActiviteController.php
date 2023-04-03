<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddSiteToActiveRequest;
use App\Http\Requests\StoreActiviteRequest;
use App\Http\Requests\UpdateActiviteRequest;
use App\Http\Resources\ActiviteResource;
use App\Models\Activite;
use Illuminate\Http\Request;

class ActiviteController extends Controller
{
    public function addSite(AddSiteToActiveRequest $request, $id)
    {
        $activite = Activite::findOrFail($id);
        if ($activite->sites->contains($request->site_id)) {
            return response()->json([
                'message' => 'Site already exists'
            ], 409);
        }
        $activite->sites()->attach($request->site_id, [
            'type' => $request->has('type') ? $request->type : 'obligatoire',
            'price' => $request->has('type') && $request->type === 'optionnel' ? $request->price : null
        ]);
        return response()->json([
            'message' => 'Site added successfully',
            'data' => new ActiviteResource($activite)
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activite = Activite::orderBy('created_at', 'desc')->get();
        return response()->json([
            'message' => 'Activite found successfully',
            'data' => ActiviteResource::collection($activite)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreActiviteRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image_path')) {
            $data['image_path'] = saveFileToStorageDirectory($request, 'image_path', 'activites');
        }
        // $data['image_path'] = saveFileToStorageDirectory($request, 'image_path', 'activites');
        $activite = Activite::create($data);
        return response()->json([
            'message' => 'Activite created successfully',
            'data' => new ActiviteResource($activite)
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
        $activite = Activite::findOrFail($id);
        return response()->json([
            'message' => 'Activite found successfully',
            'data' => new ActiviteResource($activite)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateActiviteRequest $request, $id)
    {
        $activite = Activite::findOrFail($id);
        $data = $request->validated();
        if ($request->hasFile('image_path')) {
            $data['image_path'] = saveFileToStorageDirectory($request, 'image_path', 'activites');
        }
        // $data['image_path'] = saveFileToStorageDirectory($request, 'image_path', 'activites');
        $activite->update($data);
        return response()->json([
            'message' => 'Activite updated successfully',
            'data' => new ActiviteResource($activite)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->middleware('admin');

        $activite = Activite::findOrFail($id);
        $activite->delete();
        return response()->json([
            'message' => 'Activite deleted successfully',
            'data' => new ActiviteResource($activite)
        ]);
    }
}
