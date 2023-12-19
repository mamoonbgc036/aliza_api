<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        // $request->user()->currentAccessToken()->delete();
        $user = Auth::user();
        // return $user;
        // return $user;
        // Auth::logout();
        // Auth::user()->currentAccessToken()->delete();
        $user->currentAccessToken()->delete();
        return response()->json(['message' => $user]);
    }
}
