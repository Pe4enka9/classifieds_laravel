<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorizationRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Регистрация
    public function registration(RegistrationRequest $request): JsonResponse
    {
        $user = User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json([
            'user' => new UserResource($user),
        ], 201);
    }

    // Авторизация
    public function authorization(AuthorizationRequest $request): JsonResponse
    {
        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json([], 401);
        }

        return response()->json([
            'user' => new UserResource($user),
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }

    // Выход
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json(null, 204);
    }
}
