<?php

namespace App\Http\Controllers;

use App\Models\Raiting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RaitingController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $raitings = Raiting::query()
            ->when($request->input("user_id"), function ($query, $user_id) {
                $query->where("user_id", $user_id);
            })
            ->when($request->input("raitable_id"), function ($query, $raitable_id) {
                $query->where("raitable_id", $raitable_id);
            })
            ->when($request->input("raitable_type"), function ($query, $raitable_type) {
                $query->where("raitable_type", $raitable_type);
            })
            ->get();

        return $this->sendResponse(
            data: $raitings,
            message: "Raitings retrieved successfully."
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            "value" => "required|integer",
            "raitable_id" => "required|integer",
            "raitable_type" => "required|string",
        ]);

        $raiting = Raiting::query()
            ->create($request->all());

        return $this->sendResponse(
            data: $raiting,
            message: "Raiting created successfully."
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $raiting = Raiting::query()
            ->find($id);
        if (is_null($raiting)) {
            return $this->sendError(
                error: "Raiting not found."
            );
        }
        return $this->sendResponse(
            data: $raiting,
            message: "Raiting retrieved successfully."
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            "value" => "required|integer",
            "raitable_id" => "required|integer",
            "raitable_type" => "required|string",
        ]);

        $raiting = Raiting::query()
            ->find($id);
        if (is_null($raiting)) {
            return $this->sendError(
                error: "Raiting not found."
            );
        }
        $raiting->update($request->all());

        return $this->sendResponse(
            data: $raiting,
            message: "Raiting updated successfully."
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $raiting = Raiting::query()
            ->find($id);
        if (is_null($raiting)) {
            return $this->sendError(
                error: "Raiting not found."
            );
        }
        $raiting->delete();

        return $this->sendResponse(
            data: null,
            message: "Raiting deleted successfully."
        );
    }
}
