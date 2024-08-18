<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\V1\LoginUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(LoginUserRequest $request)
    {
        $user_login_validation = $request->validated();
        $is_user_exist = User::where('phone', $user_login_validation['phone'])->first();
        if ($is_user_exist && Hash::check($user_login_validation['password'], $is_user_exist->password)) {
            $token = $is_user_exist->createToken('api_token')->plainTextToken;
            return response()->json(['user' => $is_user_exist, 'token' => $token]);
        }

        return response()->json(['warning' => 'Invalid credentials'], 401);
    }
}
