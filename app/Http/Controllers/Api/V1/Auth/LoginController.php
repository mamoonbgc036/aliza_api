<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\V1\LoginUserRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(LoginUserRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['user' => $user, 'token' => $token]);
        }
        return response()->json(['warning' => 'Invalid credentials'], 401);
    }
}
