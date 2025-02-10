<?php

use App\Http\Controllers\Api\Task\TaskController;
use Illuminate\Support\Facades\Route;



Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/teams/{team}/tasks', [TaskController::class, 'index']);
    Route::post('/teams/{team}/tasks', [TaskController::class, 'store']);
    Route::get('/task/show/{task}', [TaskController::class, 'show']);
    Route::put('/tasks/{task}', [TaskController::class, 'update']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
});
