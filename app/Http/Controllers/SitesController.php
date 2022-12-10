<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiteRequest;
use App\Http\Requests\UpdateSiteRequest;
use App\Http\Resources\SiteResource;
use App\Models\Site;
use Illuminate\Http\Request;

class SitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = Site::pagniate(10);
        return response()->json([
            'message' => 'Sites found successfully',
            'sites' => SiteResource::collection($sites)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSiteRequest $request)
    {
        $site = Site::create($request->validated());
        return response()->json([
            'message' => 'Site created successfully',
            'site' => new SiteResource($site)
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
            'site' => new SiteResource($site)
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
        $site = Site::findOrFail($id);
        $site->update($request->validated());
        return response()->json([
            'message' => 'Site updated successfully',
            'site' => new SiteResource($site)
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
        $site = Site::findOrFail($id);
        $site->delete();
        return response()->json([
            'message' => 'Site deleted successfully',
            'site' => new SiteResource($site)
        ]);
    }
}
