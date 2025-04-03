<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(RegisterRequest $request) {
        $validated = $request->validated();
        User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);

        return response()->json([
            'message' => 'User registered successfully'
        ]);
    }

    public function login(LoginRequest $request) {
        $validated = $request->validated();
        $user = User::where('email', $validated['email'])->first();
        if(!$user || Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'error' => 'Invalid credentials'
            ], 422);
        }

        $token = $user->createToken($user->username . $user->email)->plainTextToken;
        return response()->json([
            'message' => 'Login successful',
            'userId' => $user->id,
            'token' => $token
        ]);
    }

    public function getById(string $id) {
        $user = User::with('products')->find($id);
        if(!$user) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
        return response()->json([
            'message' => 'Fetched user successfully',
            'user' => $user
        ]);
    }
}
