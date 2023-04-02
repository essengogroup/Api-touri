<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddSiteToActiveRequest;
use App\Http\Requests\StoreSiteRequest;
use App\Http\Requests\UpdateSiteRequest;
use App\Http\Resources\SiteResource;
use App\Models\Site;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SitesController extends Controller
{
    public function removeActivite($id, $activite_id)
    {
        $site = Site::findOrFail($id);
        if (!$site->activites->contains($activite_id)) {
            return response()->json([
                'message' => 'Activite does not exists'
            ], 409);
        }
        $site->activites()->detach($activite_id);
        return response()->json([
            'message' => 'Activite removed successfully',
            'data' => new SiteResource($site)
        ]);
    }

    public function updateActivite(AddSiteToActiveRequest $request, $id, $activite_id)
    {
        $site = Site::findOrFail($id);
        if (!$site->activites->contains($activite_id)) {
            return response()->json([
                'message' => 'Activite does not exists'
            ], 409);
        }
        $site->activites()->updateExistingPivot($activite_id, [
            'type' => $request->has('type') ? $request->type : 'obligatoire',
            'price' => $request->has('type') && $request->type === 'optionnel' ? $request->price : null
        ]);
        return response()->json([
            'message' => 'Activite updated successfully',
            'data' => new SiteResource($site)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addActivite(AddSiteToActiveRequest $request, $id)
    {
        $site = Site::findOrFail($id);
        if ($site->activites->contains($request->activite_id)) {
            return response()->json([
                'message' => 'Activite already exists'
            ], 409);
        }
        $site->activites()->attach($request->activite_id, [
            'type' => $request->has('type') ? $request->type : 'obligatoire',
            'price' => $request->has('type') && $request->type === 'optionnel' ? $request->price : null
        ]);
        return response()->json([
            'message' => 'Activite added successfully',
            'data' => new SiteResource($site)
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = Site::orderBy('created_at', 'desc')->get();
        return SiteResource::collection($sites);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSiteRequest $request)
    {
        $this->middleware('admin');
        $site = Site::create($request->validated());
        return response()->json([
            'message' => 'Site created successfully',
            'data' => new SiteResource($site)
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
        $site = Site::findOrFail($id);
        return response()->json([
            'message' => 'Site found successfully',
            'data' => new SiteResource($site)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSiteRequest $request, $id)
    {
        $this->middleware('admin');
        $site = Site::findOrFail($id);
        $site->update($request->validated());
        return response()->json([
            'message' => 'Site updated successfully',
            'data' => new SiteResource($site)
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
        $site = Site::findOrFail($id);
        $site->delete();
        return response()->json([
            'message' => 'Site deleted successfully',
            'data' => new SiteResource($site)
        ]);
    }
}
