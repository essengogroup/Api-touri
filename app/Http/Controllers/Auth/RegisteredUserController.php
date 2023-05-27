<?php

namespace App\Http\Controllers\Auth;

use App\Constants\RoleConstants;
use App\Http\Controllers\ApiController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends ApiController
{
    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole(RoleConstants::CLIENT);

        event(new Registered($user));

        Auth::login($user);

        return $this->sendResponse(
            data: [
                'user' => new UserResource($user),
                'token' => $user->createToken('auth_token')->plainTextToken,
                'token_type' => 'Bearer Token',
            ],
            message: 'User created successfully',
            code: 201
        );
    }
}
