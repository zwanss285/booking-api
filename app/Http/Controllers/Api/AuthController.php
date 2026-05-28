<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        
        $token = $user->createToken('auth-token')->plainTextToken;
        
        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'data' => [
                'user' => new UserResource($user),
                'token' => $token
            ]
        ], 201);
    }
    
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }
        
        $user = Auth::user();
        $token = $user->createToken('auth-token')->plainTextToken;
        
        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => new UserResource($user),
                'token' => $token
            ]
        ]);
    }
    
    public function logout()
    {
        $user = Auth::user();
        if ($user) {
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }
}