<?php

use App\Http\Controllers\Api\Team\InvitationController;
use App\Http\Controllers\Api\Team\TeamController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->group(function () {

    Route::apiResource('teams', TeamController::class);
    Route::post('/teams/{team}/invite', [InvitationController::class, 'invite']);
    Route::post('/teams/accept-invitation', [InvitationController::class, 'acceptInvitation']);
    Route::get('/teams/{team}/members', [TeamController::class, 'members']);
});
