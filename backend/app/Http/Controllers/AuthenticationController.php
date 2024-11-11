<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $request = $request->validate([
            'name' => ['string', 'required'],
            'email' => ['string', 'email', 'unique:users', 'required'],
            'password' => ['string', 'required']
        ]);
        Auth::login(User::create($request));
        return response()->json([
            'success' => 'Successful registraion.'
        ], 200);
    }

    public function login(Request $request): JsonResponse
    {
        $request = $request->validate([
            'email' => ['string', 'email', 'required'],
            'password' => ['string', 'required']
        ]);
        if (Auth::attempt($request)) {
            return response()->json([
                'success' => 'Successful login.'
            ], 200);
        } else {
            return response()->json([
                'error' => 'Invalid credentials'
            ], 401);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json([
            'success' => 'Successful logout.'
        ], 200);
    }
}
