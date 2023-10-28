<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Commom\AuthLoginRequest;
use App\Http\Resources\LoginResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(AuthLoginRequest $authLoginRequest)
    {
        $credentials = $authLoginRequest->validated();

        if (Auth::attempt($credentials)) {
            $token = $authLoginRequest->user()->createToken('token')->plainTextToken;
            $response = ['token' => $token, 'user' => Auth::user()];

            return (new LoginResource($response))
                ->response();
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out'], 200);
    }
}
