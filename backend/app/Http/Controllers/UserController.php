<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(User::all());
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            $user = User::create($request->json()->all());
        } catch (Exception) {
            return response()->json(['error' => 'Internal server error.'], 500);
        }
        return response()->json($user, 201);
    }

    public function edit(int $id): JsonResponse
    {
        $user = User::find($id);
        if ($user === null) {
            return response()->json(['error' => 'User not found.'], 404);
        }
        $user->active = !$user->active;
        try {
            $user->save();
        } catch (Exception) {
            return response()->json(['error' => 'Internal server error.'], 500);
        }
        return response()->json($user);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = User::find($id);
        if ($user === null) {
            return response()->json(['error' => 'User not found.'], 404);
        }
        try {
            $user->update($request->json()->all());
        } catch (Exception) {
            return response()->json(['error' => 'Internal server error.'], 500);
        }
        return response()->json($user);
    }
}
