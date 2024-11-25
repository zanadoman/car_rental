<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReceiptController extends Controller
{
    public function index(): JsonResponse{
        switch (Auth::user()->role){
            case 'customer':
                $receipts = Receipt::where('user_id', '=', Auth::user()->id)->get();
                break;
            case 'salesman':
            case 'admin':
                $receipts = Receipt::all();
                break;
        }
        return response()->json($receipts, 200);
    }

    public function store(Request $request): JsonResponse{
        $validator = Validator::make($request->json()->all(), [
            'user_id' => 'required|integer|min:0',
            'car_id' => 'required|integer|min:0',
            'kilometers' => 'required|integer|min:0',
            'begin' => 'required|date',
            'end' => 'required|date',
            'delay' => 'nullable|date',
            'totalfee' => 'required|integer|min:0',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            $receipt = Receipt::create($request->json()->all());
        } catch (Exception) {
            return response()->json(['error' => 'Internal server error.', 500]);
        }
        return response()->json([
            'id' => $receipt->id,
            'user_id' => $receipt->user_id,
            'car_id' => $receipt->car_id,
            'kilometers' => $receipt->kilometers,
            'begin' => $receipt->begin,
            'end' => $receipt->end,
            'delay' => $receipt->delay,
            'totalfee' => $receipt->totalfee,
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse{
        $validator = Validator::make($request->json()->all(), [
            'user_id' => 'required|integer|min:0',
            'car_id' => 'required|integer|min:0',
            'kilometers' => 'required|integer|min:0',
            'begin' => 'required|date',
            'end' => 'required|date',
            'delay' => 'nullable|date',
            'totalfee' => 'required|integer|min:0',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $receipt = Receipt::find($id);
        if ($receipt === null) {
            return response()->json(['error' => 'Receipt not found.', 404]);
        }
        try {
            $receipt->update($request->json()->all());
        } catch (Exception) {
            return response()->json(['error' => 'Internal server error.', 500]);
        }
        return response()->json([
            'id' => $receipt->id,
            'user_id' => $receipt->user_id,
            'car_id' => $receipt->car_id,
            'kilometers' => $receipt->kilometers,
            'begin' => $receipt->begin,
            'end' => $receipt->end,
            'delay' => $receipt->delay,
            'totalfee' => $receipt->totalfee,
        ], 200);
    }

    public function destroy(int $id): Response
    {
        $receipt = Receipt::find($id);
        if ($receipt === null) {
            return response()->json(['error' => 'Receipt not found.', 404]);
        }
        try {
            $receipt->delete();
        } catch (Exception) {
            return response()->json(['error' => 'Internal server error.', 500]);
        }
        return response()->noContent();
    }
}
