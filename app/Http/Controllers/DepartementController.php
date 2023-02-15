<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartementRequest;
use App\Http\Requests\UpdateDepartementRequest;
use App\Http\Resources\DepartementResource;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     *@OA\Get(
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
    public function index()
    {
        $departements = Departement::orderBy('created_at', 'desc')->paginate();
        return DepartementResource::collection($departements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
    public function store(StoreDepartementRequest $request)
    {

        $departement = Departement::create($request->validated());
        return response()->json([
            'message' => 'Departement created successfully',
            'data' => $departement
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
    public function show($id)
    {
        $departement = Departement::findOrFail($id);
        return response()->json([
            'message' => 'Departement found successfully',
            'data' => new DepartementResource($departement)
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
    public function update(UpdateDepartementRequest $request, $id)
    {
        $departement = Departement::findOrFail($id);
        $departement->update($request->validated());
        return response()->json([
            'message' => 'Departement updated successfully',
            'data' => new DepartementResource($departement)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
    public function destroy($id)
    {
        $departement = Departement::findOrFail($id);
        $departement->delete();
        return response()->json([
            'message' => 'Departement deleted successfully',
            'data' => new DepartementResource($departement)
        ]);
    }
}
