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

        // Why does the user have so many things in the migration even though i thought it was clear we're only getting code and password?
        // Passing them as hardcoded default values for now cause i can't be bothered to change the migration for now
        $user = User::create([
            'id' => (string) Str::uuid(),
            'code' => $request->code,
            'password' => bcrypt($request->password),
            'isAdmin' => false,
            'avatarId' => 1,
            'age' => 0,
            'sexe' => 'N/A',
            'jobId' => 0,
            'shareData' => true,
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
        return $request->user();
    }


}
