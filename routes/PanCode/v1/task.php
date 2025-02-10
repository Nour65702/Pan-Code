<?php

use App\Http\Controllers\Api\Task\TaskController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('teams/{team}/tasks')->controller(TaskController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
    });

    Route::prefix('tasks')->controller(TaskController::class)->group(function () {
        Route::get('/{task}', 'show');
        Route::put('/{task}', 'update');
        Route::delete('/{task}', 'destroy');
    });
});
