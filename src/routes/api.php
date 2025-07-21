<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ExpenseController;

// Endpoint untuk API Pengeluaran (membutuhkan otentikasi)
Route::apiResource('expenses', ExpenseController::class)->middleware('auth:sanctum');

// Endpoint untuk login dan mendapatkan token API
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (!auth()->attempt($credentials)) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $token = $request->user()->createToken('api-token')->plainTextToken;

    return response()->json(['token' => $token]);
});