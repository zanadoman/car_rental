<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    public function index(): JsonResponse
    {
        switch (Auth::user()->role) {
            case 'customer':
                $cars = Car::whereRaw('kilometers < next_maintenance')->get();
                break;
            case 'mechanic':
                $cars = Car::whereRaw('next_maintenance <= kilometers')->get();
                break;
            case 'salesman':
                $cars = Car::whereRaw('kilometers < next_maintenance')->get();
                break;
            case 'admin':
                $cars = Car::all();
                break;
        }
        return response()->json($cars, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'license' => 'required|string|max:255|unique:cars',
            'brand' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'kilometers' => 'required|integer|min:0',
            'dailyfee' => 'required|integer|min:0',
            'last_maintenance' => 'required|integer|min:0',
            'next_maintenance' => 'required|integer|min:0',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        if ($request->json()->get('next_maintenance') <= $request->json()->get('last_maintenance')) {
            return response()->json([
                'next_maintenance' => ['The next maintenance must be greater than the last maintenance.'],
            ], 400);
        }
        try {
            $car = Car::create($request->json()->all());
        } catch (Exception) {
            return response()->json(['error' => 'Internal server error.', 500]);
        }
        return response()->json($car, 201);
    }

    public function edit(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'next_maintenance' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $car = Car::find($id);
        if ($car === null) {
            return response()->json(['error' => 'Car not found.', 404]);
        }
        $car->last_maintenance = $car->kilometers;
        if ($request->json()->get('next_maintenance') <= $car->last_maintenance) {
            return response()->json([
                'next_maintenance' => ['The next maintenance must be greater than the last maintenance.'],
            ], 400);
        }
        $car->next_maintenance = $request->json()->get('next_maintenance');
        try {
            $car->save();
        } catch (Exception) {
            return response()->json(['error' => 'Internal server error.', 500]);
        }
        return response()->json($car, 200);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'license' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'kilometers' => 'required|integer|min:0',
            'dailyfee' => 'required|integer|min:0',
            'last_maintenance' => 'required|integer|min:0',
            'next_maintenance' => 'required|integer|min:0',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        if ($request->json()->get('next_maintenance') <= $request->json()->get('last_maintenance')) {
            return response()->json([
                'next_maintenance' => ['The next maintenance must be greater than the last maintenance.'],
            ], 400);
        }
        $car = Car::find($id);
        if ($car === null) {
            return response()->json(['error' => 'Car not found.', 404]);
        }
        try {
            $car->update($request->json()->all());
        } catch (Exception) {
            return response()->json(['error' => 'Internal server error.', 500]);
        }
        return response()->json($car, 200);
    }

    public function destroy(int $id): Response
    {
        $car = Car::find($id);
        if ($car === null) {
            return response()->json(['error' => 'Car not found.', 404]);
        }
        try {
            $car->delete();
        } catch (Exception) {
            return response()->json(['error' => 'Internal server error.', 500]);
        }
        return response()->noContent();
    }
}
