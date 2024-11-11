<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthenticationController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'name' => 'string|max:255|required',
            'email' => 'string|max:255|email|unique:users|required',
            'password' => 'string|min:8|required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            $user = User::create($request->json()->all());
        } catch (Exception) {
            return response()->json(['error' => 'Internal server error.'], 500);
        }
        Auth::login($user);
        return response()->json(['success' => 'Successful registration.'], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'name' => 'string|required',
            'email' => 'string|required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->error(), 400);
        }
        if (Auth::attempt($request->json()->all())) {
            return response()->json(['success' => 'Successful login.'], 200);
        }
        return response()->json(['error' => 'Invalid credentials.'], 401);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['success' => 'Successful logout.'], 200);
    }
}
