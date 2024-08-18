<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\V1\StoreUserRequest;
use Exception;

class RegisterController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        try {
            $data = $request->validated();
            if ($request->hasFile('image')) {
                $admin_image_path  = Storage::put('/admin', $request->file('image'));
                $data['image'] = env('APP_URL') . '/storage/' . $admin_image_path;
            }
            $user = User::create($data);
            Auth::login($user);
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['user' => $user, 'token' => $token]);
        } catch (Exception $e) {
            logger('Error: ' . $e->getMessage());
            return response()->json(['danger' => $e->getMessage()]);
        }
    }
}
