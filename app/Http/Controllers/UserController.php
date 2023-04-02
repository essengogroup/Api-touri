<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Doctrine\Inflector\Rules\French\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message' => 'Users found successfully',
            'data' => UserResource::collection(User::orderBy('created_at', 'desc')->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'message' => 'User found successfully',
            'data' => new UserResource(User::find($id))
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserequest $request, User $user)
    {
        $data = $request->validated();
        if (collect($data)->has('password')) {
            $data['password'] = Hash::make($request->password);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->middleware('admin');
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully',
            'data' => new UserResource($user)
        ]);
    }
}
