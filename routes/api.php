<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JobController;

// login & register authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);

// Endpoint yang bisa diakses tanpa autentikasi
Route::get('/jobs', [JobController::class, 'index']);  
Route::get('/jobs/{id}', [JobController::class, 'show']);  

// group routes authentication jobs (hanya untuk user terautentikasi)
Route::middleware('auth:api')->group(function () {
    Route::post('/jobs', [JobController::class, 'store']);
    Route::put('/jobs/{id}', [JobController::class, 'update']);
    Route::delete('/jobs/{id}', [JobController::class, 'destroy']);
});