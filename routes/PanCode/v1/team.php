<?php

use App\Http\Controllers\Api\Team\InvitationController;
use App\Http\Controllers\Api\Team\TeamController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('teams', TeamController::class);

    Route::prefix('teams')->group(function () {
        Route::controller(InvitationController::class)->group(function () {
            Route::post('{team}/invite', 'invite');
            Route::post('accept-invitation', 'acceptInvitation');
        });

        Route::get('{team}/members', [TeamController::class, 'members']);
    });
});
