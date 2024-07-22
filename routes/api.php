<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('auth/login', LoginController::class);
Route::apiResource('tasks', TaskController::class)->middleware('auth:sanctum');