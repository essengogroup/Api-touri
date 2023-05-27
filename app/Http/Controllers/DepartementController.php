<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartementRequest;
use App\Http\Requests\UpdateDepartementRequest;
use App\Http\Resources\DepartementResource;
use App\Models\Departement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class DepartementController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @OA\Get(
     *  path="/departements",
     *  operationId="getDepartementsList",
     *  tags={"Departements"},
     *  summary="Get list of departements",
     *  description="Returns list of departements",
     *  @OA\Response(
     *      response=200,
     *      description="Successful operation",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/Departement")
     *      ),
     *  ),
     *  @OA\Response(
     *      response="default",
     *      description="unexpected error",
     *      @OA\JsonContent(
     *      @OA\Property(property="message", type="string", example="Unexpected error")
     *  )
     * )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $departments = Departement::query()
            ->when(request('search'), function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            })
            ->when(request('sort'), function ($query) {
                $sort = explode('|', request('sort'));
                $query->orderBy($sort[0], $sort[1]);
            }, function ($query) {
                $query->orderBy('created_at', 'desc');
            })
            ->when(request('limit'), function ($query) {
                $query->limit(request('limit'));
            })
            ->when(request('offset'), function ($query) {
                $query->offset(request('offset'));
            })
            ->orderBy('created_at', 'desc');
        return $this->sendResponse(
            data: DepartementResource::collection($departments->get()),
            message: 'list of departements'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDepartementRequest $request
     * @return JsonResponse
     *
     * @OA\Post(
     * path="/departements",
     * summary="Store new departement",
     * description="Returns departement data",
     * operationId="storeDepartement",
     * tags={"Departements"},
     * @OA\RequestBody(
     *   required=true,
     *  @OA\JsonContent(ref="#/components/schemas/Departement")
     * ),
     * @OA\Response(
     *   response=200,
     *  description="Successful operation",
     * @OA\JsonContent(ref="#/components/schemas/Departement")
     * ),
     * @OA\Response(
     *  response="default",
     * description="unexpected error",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Unexpected error")
     * )
     * )
     * )
     */
    public function store(StoreDepartementRequest $request): JsonResponse
    {
        $data = $request->validated();
        if ($request->hasFile('image_path')) {
            $data['image_path'] = saveFileToStorageDirectory($request, 'image_path', 'departements');
        }
        $departement = Departement::create($data);
        return $this->sendResponse(
            data: new DepartementResource($departement),
            message: 'departement created successfully'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Get(
     * path="/departements/{id}",
     * summary="Get departement information",
     * description="Returns departement data",
     * operationId="showDepartement",
     * tags={"Departements"},
     * @OA\Parameter(
     *  name="id",
     * description="Departement id",
     * required=true,
     * in="path",
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Successful operation",
     * @OA\JsonContent(ref="#/components/schemas/Departement")
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
        $departement = Departement::query()->find($id);
        if (!$departement) {
            return $this->sendError(error: 'departement not found');
        }
        return $this->sendResponse(
            data: new DepartementResource($departement),
            message: 'departement retrieved successfully'
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDepartementRequest $request
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Put(
     * path="/departements/{id}",
     * summary="Update existing departement",
     * description="Returns updated departement data",
     * operationId="updateDepartement",
     * tags={"Departements"},
     * @OA\Parameter(
     * name="id",
     * description="Departement id",
     * required=true,
     * in="path",
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/Departement")
     * ),
     * @OA\Response(
     * response=200,
     * description="Successful operation",
     * @OA\JsonContent(ref="#/components/schemas/Departement")
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
    public function update(UpdateDepartementRequest $request, int $id): JsonResponse
    {
        $departement = Departement::find($id);
        if (!$departement) {
            return $this->sendError(error: 'departement not found');
        }
        $data = $request->validated();
        $departement->update($data);
        return $this->sendResponse(
            data: new DepartementResource($departement),
            message: 'departement updated successfully'
        );
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateImagePath(Request $request, int $id): JsonResponse
    {
        $departement = Departement::find($id);
        if (!$departement) {
            return $this->sendError(error: 'departement not found');
        }
        $data = $request->validate([
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $data['image_path'] = saveFileToStorageDirectory($request, 'image_path', 'departements');
        $departement->update($data);
        return $this->sendResponse(
            data: new DepartementResource($departement),
            message: 'departement updated successfully'
        );
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     *
     * @OA\Delete(
     * path="/departements/{id}",
     * summary="Delete existing departement",
     * description="Returns message",
     * operationId="deleteDepartement",
     * tags={"Departements"},
     * @OA\Parameter(
     * name="id",
     * description="Departement id",
     * required=true,
     * in="path",
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Successful operation",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Departement deleted successfully"),
     * @OA\Property(property="departement", ref="#/components/schemas/Departement")
     * )
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
        $departement = Departement::query()->find($id);
        if (!$departement) {
            return $this->sendError(error: 'departement not found');
        }
        $departement->delete();
        return $this->sendResponse(
            data: null,
            message: 'departement deleted successfully'
        );
    }
}
