<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'nullable|string',
            'email' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);
        $users = User::query()
            ->when($request->has('name'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%');
            })
            ->when($request->has('email'), function ($query) use ($request) {
                $query->where('email', 'like', '%' . $request->email . '%');
            })
            ->when($request->has('phone'), function ($query) use ($request) {
                $query->where('phone', 'like', '%' . $request->phone . '%');
            })
            ->when($request->has('address'), function ($query) use ($request) {
                $query->where('address', 'like', '%' . $request->address . '%');
            });

        return $this->sendResponse(
            data: UserResource::collection($users->get()),
            message: 'list of users'
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
        $user = User::query()->find($id);
        if ($user) {
            return $this->sendResponse(
                data: new UserResource($user),
                message: 'user retrieved successfully'
            );
        } else {
            return $this->sendError(
                error: 'user not found',
                code: 404
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UpdateUserequest $request, User $user): JsonResponse
    {
        $data = $request->validated();
        if (collect($data)->has('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        return $this->sendResponse(
            data: new UserResource($user),
            message: 'user updated successfully'
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function updateProfileImage(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = saveFileToStorageDirectory($request, 'profile_picture', 'profile_picture');
        }
        $user->update($data);
        return response()->json([
            'message' => 'User updated successfully',
            'data' => new UserResource($user)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->middleware('admin');
        $user = User::query()->find($id);
        if ($user) {
            $user->delete();
            return $this->sendResponse(
                data: null,
                message: 'user deleted successfully'
            );
        } else {
            return $this->sendError(
                error: 'user not found',
                code: 404
            );
        }
    }
}
