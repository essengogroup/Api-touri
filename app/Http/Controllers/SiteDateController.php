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
     *
     * @OA\Get(
     * path="/site-dates",
     * summary="Get list of site dates",
     * description="Returns list of site dates",
     * operationId="getSiteDatesList",
     * tags={"Site Dates"},
     * @OA\Response(
     *  response=200,
     * description="Successful operation",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(ref="#/components/schemas/SiteDate")
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
    public function index()
    {
        $siteDates = SiteDate::orderBy('created_at', 'desc')->paginate();
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
     *
     * @OA\Post(
     * path="/site-dates",
     * summary="Store new site date",
     * description="Returns site date data",
     * operationId="storeSiteDate",
     * tags={"Site Dates"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/StoreSiteDateRequest")
     * ),
     * @OA\Response(
     * response=200,
     * description="Successful operation",
     * @OA\JsonContent(ref="#/components/schemas/SiteDate")
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
    public function store(StoreSiteDateRequest $request)
    {
        $siteDate = SiteDate::create($request->validated());
        return response()->json([
            'message' => 'Site date created successfully',
            'data' => new SiteResource($siteDate)
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * @OA\Get(
     * path="/site-dates/{id}",
     * summary="Get site date information",
     * description="Returns site date data",
     * operationId="getSiteDateById",
     * tags={"Site Dates"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID of site date to return",
     * required=true,
     * @OA\Schema(
     * type="integer",
     * format="int64"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Successful operation",
     * @OA\JsonContent(ref="#/components/schemas/SiteDate")
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
     *
     * @OA\Put(
     * path="/site-dates/{id}",
     * summary="Update existing site date",
     * description="Returns updated site date data",
     * operationId="updateSiteDate",
     * tags={"Site Dates"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID of site date to return",
     * required=true,
     * @OA\Schema(
     * type="integer",
     * format="int64"
     * )
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/UpdateSiteDateRequest")
     * ),
     * @OA\Response(
     * response=200,
     * description="Successful operation",
     * @OA\JsonContent(ref="#/components/schemas/SiteDate")
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
    public function update(UpdateSiteDateRequest $request, int $id)
    {
        $siteDate = SiteDate::findOrFail($id);
        $siteDate->update($request->validated());
        return response()->json([
            'message' => 'Site date updated successfully',
            'data' => new SiteResource($siteDate)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * @OA\Delete(
     * path="/site-dates/{id}",
     * summary="Delete existing site date",
     * description="Deletes a record and returns no content",
     * operationId="deleteSiteDate",
     * tags={"Site Dates"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID of site date to return",
     * required=true,
     * @OA\Schema(
     * type="integer",
     * format="int64"
     * )
     * ),
     * @OA\Response(
     * response=204,
     * description="Successful operation",
     * @OA\JsonContent(ref="#/components/schemas/SiteDate")
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
    public function destroy(int $id)
    {
        $siteDate = SiteDate::findOrFail($id);
        $siteDate->delete();
        return response()->json(['message' => 'Site date deleted successfully']);
    }
}
