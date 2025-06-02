<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\ApplicationController;

// Login & Register
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Public job endpoints
Route::get('/jobs', [JobController::class, 'index']);  
Route::get('/jobs/all', [JobController::class, 'allJobs']);  
Route::get('/jobs/{id}', [JobController::class, 'show']);  

Route::get('/applications/{id}', [ApplicationController::class, 'show']);
Route::get('/applications', [ApplicationController::class, 'index']);
Route::get('/jobs/{jobId}/applications', [ApplicationController::class, 'getByJob']);
Route::delete('/applications/{id}', [ApplicationController::class, 'destroy']);

// Protected job endpoints
Route::middleware('jwt.auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Job CRUD
    Route::post('/jobs', [JobController::class, 'store']);
    Route::put('/jobs/{id}', [JobController::class, 'update']);
    Route::delete('/jobs/{id}', [JobController::class, 'destroy']);

    // Job Application
    Route::post('/applications', [ApplicationController::class, 'store']);



});