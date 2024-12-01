<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;
use illuminate\Support\Facades\Validator;

class RentController extends Controller
{
    public function index(): JsonResponse
    {
        if (Auth::user()->role === 'customer') {
            $rents = Rent::where('user_id', '=', Auth::user()->id)->get();
        } else {
            $rents = Rent::all();
        }
        return response()->json($rents, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'user_id' => 'required|integer|min:0',
            'car_id' => 'required|integer|min:0',
            'kilometers' => 'required|integer|min:0',
            'begin' => 'required|date|after:today',
            'end' => 'required|date|after:begin',
            'takeaway' => 'nullable|date',
            'return' => 'nullable|date',
            'active' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        if ($request->json()->get('return') !== null && $request->json()->get('takeaway') === null) {
            return response()->json([
                'takeaway' => ["The takeaway field must not be null if the return field is not null."],
            ], 400);
        }
        try {
            $rent = Rent::create($request->json()->all());
        } catch (Exception) {
            return response()->json(['error' => 'Internal server error.'], 500);
        }
        return response()->json($rent, 201);
    }

    public function edit(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'takeaway' => 'nullable|date',
            'return' => 'nullable|date',
            'active' => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $rent = Rent::find($id);
        if ($rent === null) {
            return response()->json(['error' => 'Rent not found.'], 404);
        }
        switch (Auth::user()->role) {
            case 'customer':
                if ($rent->takeaway === null) {
                    $rent->takeaway = $request->json()->get('takeaway');
                } else if ($rent->return === null) {
                    $rent->return = $request->json()->get('return');
                }
                break;
            case 'salesman':
                if ($request->json()->get('active') !== null) {
                    $rent->active = $request->json()->get('active');
                }
                break;
            case 'admin':
                if ($request->json()->get('return') !== null && $request->json()->get('takeaway') === null) {
                    return response()->json([
                        'takeaway' => ["The takeaway field must not be null if the return field is not null."],
                    ], 400);
                }
                $rent->takeaway = $request->json()->get('takeaway');
                $rent->return = $request->json()->get('return');
                if ($request->json()->get('active') !== null) {
                    $rent->active = $request->json()->get('active');
                }
                break;
        }
        try {
            $rent->save();
        } catch (Exception) {
            return response()->json(['error' => 'Internal server error.'], 500);
        }
        return response()->json($rent, 200);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'user_id' => 'required|integer|min:0',
            'car_id' => 'required|integer|min:0',
            'kilometers' => 'required|integer|min:0',
            'begin' => 'required|date|after:today',
            'end' => 'required|date|after:begin',
            'takeaway' => 'nullable|date',
            'return' => 'nullable|date',
            'active' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        if ($request->json()->get('return') !== null && $request->json()->get('takeaway') === null) {
            return response()->json([
                'takeaway' => ["The takeaway field must not be null if the return field is not null."],
            ], 400);
        }
        $rent = Rent::find($id);
        if ($rent === null) {
            return response()->json(['error' => 'Rent not found.'], 404);
        }
        try {
            $rent->update($request->json()->all());
        } catch (Exception) {
            return response()->json(['error' => 'Internal server error.'], 500);
        }
        return response()->json($rent, 200);
    }

    public function destroy(int $id): JsonResponse
    {
        $rent = Rent::find($id);
        if ($rent === null) {
            return response()->json(['error' => 'Rent not found.'], 404);
        }
        try {
            $rent->delete();
        } catch (Exception) {
            return response()->json(['error' => 'Internal server error.'], 500);
        }
        return response()->noContent();
    }
}
