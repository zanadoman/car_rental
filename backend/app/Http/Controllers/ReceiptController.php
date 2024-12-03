<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Receipt;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReceiptController extends Controller
{
    public function index(): JsonResponse
    {
        if (Auth::user()->role === 'customer') {
            $receipts = Receipt::where('user_id', '=', Auth::user()->id)->get();
        } else {
            $receipts = Receipt::all();
        }
        return response()->json($receipts);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'user_id' => 'required|integer|min:0',
            'car_id' => 'required|integer|min:0',
            'kilometers' => 'required|integer|min:0',
            'begin' => 'required|date|before:end',
            'end' => 'required|date|before:today',
            'delay' => 'nullable|integer|min:0',
            'totalfee' => 'required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $car = Car::find($request->json()->get('car_id'));
        if ($car === null) {
            return response()->json(['error' => 'Car not found.'], 404);
        }
        if ($car->kilometers < $request->json()->get('kilometers')) {
            return response()->json([
                'kilometers' => ['The kilometers field must not be more than the kilometers of the car.'],
            ], 400);
        }
        try {
            $receipt = Receipt::create($request->json()->all());
        } catch (Exception) {
            return response()->json(['error' => 'Internal server error.'], 500);
        }
        return response()->json($receipt, 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'user_id' => 'required|integer|min:0',
            'car_id' => 'required|integer|min:0',
            'kilometers' => 'required|integer|min:0',
            'begin' => 'required|date|before:end',
            'end' => 'required|date|before:today',
            'delay' => 'nullable|integer|min:0',
            'totalfee' => 'required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $car = Car::find($request->json()->get('car_id'));
        if ($car === null) {
            return response()->json(['error' => 'Car not found.'], 404);
        }
        if ($car->kilometers < $request->json()->get('kilometers')) {
            return response()->json([
                'kilometers' => ['The kilometers field must not be more than the kilometers of the car.'],
            ], 400);
        }
        $receipt = Receipt::find($id);
        if ($receipt === null) {
            return response()->json(['error' => 'Receipt not found.'], 404);
        }
        try {
            $receipt->update($request->json()->all());
        } catch (Exception) {
            return response()->json(['error' => 'Internal server error.'], 500);
        }
        return response()->json($receipt);
    }

    public function destroy(int $id): Response
    {
        $receipt = Receipt::find($id);
        if ($receipt === null) {
            return response()->json(['error' => 'Receipt not found.'], 404);
        }
        try {
            $receipt->delete();
        } catch (Exception) {
            return response()->json(['error' => 'Internal server error.'], 500);
        }
        return response()->noContent();
    }
}
