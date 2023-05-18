<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiteDateRequest;
use App\Http\Requests\UpdateSiteDateRequest;
use App\Http\Resources\SiteDateResource;
use App\Models\SiteDate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SiteDateController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
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
    public function index(Request $request): JsonResponse
    {
        $siteDates = SiteDate::query()
            ->when($request->has('site_id'), fn($query) => $query->where('site_id', $request->get('site_id')))
            ->when($request->has('date'), fn($query) => $query->where('date', $request->get('date')))
            ->orderBy('created_at', 'desc')
            ->get();
        return $this->sendResponse(
            data: SiteDateResource::collection($siteDates),
            message: 'list of site dates');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSiteDateRequest $request
     * @return JsonResponse
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
    public function store(StoreSiteDateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $siteDate = SiteDate::create($data);
        return $this->sendResponse(
            data: new SiteDateResource($siteDate),
            message: 'site date created successfully', code: 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
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
    public function show(int $id): JsonResponse
    {
        $siteDate = SiteDate::query()->find($id);
        if (!$siteDate) {
            return $this->sendError('site date not found', code: 404);
        }
        return $this->sendResponse(
            data: new SiteDateResource($siteDate),
            message: 'site date retrieved successfully');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSiteDateRequest $request
     * @param int $id
     * @return JsonResponse
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
    public function update(UpdateSiteDateRequest $request, int $id): JsonResponse
    {
        $siteDate = SiteDate::query()->find($id);
        if (!$siteDate) {
            return $this->sendError('site date not found', code: 404);
        }
        $data = $request->validated();
        $siteDate->update($data);
        return $this->sendResponse(
            data: new SiteDateResource($siteDate),
            message: 'site date updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
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
    public function destroy(int $id): JsonResponse
    {
        $this->middleware('admin');
        $siteDate = SiteDate::query()->find($id);
        if (!$siteDate) {
            return $this->sendError('site date not found', code: 404);
        }
        $siteDate->delete();
        return $this->sendResponse(
            data: null,
            message: 'site date deleted successfully');
    }
}
