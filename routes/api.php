<?php

use App\Http\Controllers\Auth\AuthApiController;
use App\Http\Controllers\Task\TaskApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->controller(TaskApiController::class)->group(function () {
    Route::prefix('/projects/{project}/tasks')->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
    });

    Route::prefix('/tasks/{task}')->group(function () {
        Route::get('/', 'show');
        Route::put('/', 'update');
        Route::delete('/', 'destroy');
    });
});
