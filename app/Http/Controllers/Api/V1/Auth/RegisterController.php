<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\V1\StoreUserRequest;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $admin_image_path  = Storage::put('/admin', $request->file('image'));
            $data['image'] = env('APP_URL') . '/storage/' . $admin_image_path;
        }
        $user = User::create($data);
        Auth::login($user);
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token]);
    }
}
