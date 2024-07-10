<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);
        $user = User::where('email',  $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => ['Username or password incorrect'],
            ]);
        }

        $user->tokens()->delete();
        $data = new UserResource($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'user' => $data,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }
}
