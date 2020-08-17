<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class)
        ->only('index');

    Route::apiResource('tasks', TaskController::class)
        ->except(['create', 'show', 'edit']);
});
