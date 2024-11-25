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
        switch (Auth::user()->role) {
            case 'customer':
                $rents = Rent::where('user_id', '=', Auth::user()->id)->get();
                break;
            case 'salesman':
            case 'admin':
                $rents = Rent::all();
                break;
        }
        return response()->json($rents, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            // userid,carid,begin,end
            'user_id' => 'required|integer|min:0',
            'car_id' => 'required|integer|min:0',
            'begin' => 'required|date',
            'end' => 'required|date',
            'takeaway' => 'nullable',
            'return' => 'nullable'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            $rent = Rent::create($request->json()->all());
        } catch (Exception) {
            return response()->json(['error' => 'Internal server error.', 500]);
        }
        return response()->json([
            'id' => $rent->id,
            'user_id' => $rent->user_id,
            'car_id' => $rent->car_id,
            'kilometers' => $rent->kilometers,
            'begin' => $rent->date,
            'end' => $rent->end,
            'takeaway' => $rent->takeaway,
            'return' => $rent->return,
            'active' => $rent->active
        ], 201);
    }

    public function edit(Request $request, int $id): JsonResponse
    {
        $rent = Rent::find($id);
        if ($rent === null) {
            return response()->json(['error' => 'Rent not found.', 404]);
        }
        $validator = Validator::make($request->json()->all(), [
            'takeaway' => 'nullable|date',
            'return' => 'nullable|date',
            'active' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            $rent->update($request->json()->all());
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to update rent.'], 500);
        }
        return response()->json($rent, 200);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $rent = Rent::find($id);
        if ($rent === null) {
            return response()->json(['error' => 'Rent not found.'], 404);
        }
        $validator = Validator::make($request->json()->all(), [
            'user_id' => 'nullable|integer|min:0',
            'car_id' => 'nullable|integer|min:0',
            'begin' => 'nullable|date',
            'end' => 'nullable|date',
            'takeaway' => 'nullable|date',
            'return' => 'nullable|date',
            'kilometers' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
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
            return response()->json(['error' => 'Failed to delete rent.'], 500);
        }
        return response()->noContent();
    }
}
