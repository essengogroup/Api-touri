<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiteDateRequest;
use App\Http\Requests\UpdateSiteDateRequest;
use App\Http\Resources\SiteResource;
use App\Models\SiteDate;
use Illuminate\Http\Request;

class SiteDateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $siteDates = SiteDate::paginate();
        return response()->json([
            'message' => 'Site dates found successfully',
            'data' => SiteResource::collection($siteDates)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSiteDateRequest $request)
    {
        $siteDate = SiteDate::create($request->validated());
        return response()->json([
            'message' => 'Site date created successfully',
            'data' => $siteDate
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $siteDate = SiteDate::findOrFail($id);
        return response()->json([
            'message' => 'Site date found successfully',
            'data' => new SiteResource($siteDate)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSiteDateRequest $request, int $id)
    {
        $siteDate = SiteDate::findOrFail($id);
        $siteDate->update($request->validated());
        return response()->json([
            'message' => 'Site date updated successfully',
            'siteDate' => $siteDate
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $siteDate = SiteDate::findOrFail($id);
        $siteDate->delete();
        return response()->json(['message' => 'Site date deleted successfully']);
    }
}
