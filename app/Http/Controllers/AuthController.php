<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'id' => (string) Str::uuid(),
            'code' => $request->code,
            'password' => bcrypt($request->password),
            'isAdmin' => false,
            'avatarId' => 1,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('code', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('code', $request['code'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user();
        $user->load('challenges', 'daily_steps');
        return response()->json($user);
    }

    public function unauthorized()
    {
        return response()->json([
            'message' => 'You need to be connected to access this ressource.'
        ], 401);
    }


}
