<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartementRequest;
use App\Http\Requests\UpdateDepartementRequest;
use App\Http\Resources\DepartementResource;
use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departements = Departement::paginate(10);
        return response()->json([
            'message' => 'Departements found successfully',
            'departements' => DepartementResource::collection($departements)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartementRequest $request)
    {
        $departement = Departement::create($request->validated());
        return response()->json([
            'message' => 'Departement created successfully',
            'departement' => $departement
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
        $departement = Departement::findOrFail($id);
        return response()->json([
            'message' => 'Departement found successfully',
            'departement' => new DepartementResource($departement)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartementRequest $request, $id)
    {
        $departement = Departement::findOrFail($id);
        $departement->update($request->validated());
        return response()->json([
            'message' => 'Departement updated successfully',
            'departement' => new DepartementResource($departement)
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
        $departement = Departement::findOrFail($id);
        $departement->delete();
        return response()->json([
            'message' => 'Departement deleted successfully',
            'departement' => new DepartementResource($departement)
        ]);
    }
}
