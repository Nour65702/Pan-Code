<?php

use App\Http\Controllers\Api\Task\TaskController;
use App\Http\Controllers\Api\Team\TeamController;
use App\Http\Middleware\TenantMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



// Route::middleware(['auth:sanctum'])->group(function () {
//     // 🏢 Team Routes
//     Route::apiResource('teams', TeamController::class);
//     Route::post('/teams/{team}/invite', [TeamController::class, 'invite']); // Invite a user to a team
//     Route::post('/teams/accept-invitation', [TeamController::class, 'acceptInvitation']); // Accept team invitation
//     Route::get('/teams/{team}/members', [TeamController::class, 'members']); // Get team members

//     // 📌 Task Routes (Tasks Belong to Teams)
//     Route::get('/teams/{team}/tasks', [TaskController::class, 'index']); // Get all tasks in a team (with filters)
//     Route::post('/teams/{team}/tasks', [TaskController::class, 'store']); // Create a task for a team
//     Route::get('/task/show/{task}', [TaskController::class, 'show']); // Get task details
//     Route::put('/tasks/{task}', [TaskController::class, 'update']); // Update a task (includes reassigning)
//     Route::delete('/tasks/{task}', [TaskController::class, 'destroy']); // Delete a task
// });



$dev_path = __DIR__ . '../PanCode/v1/';

Route::prefix('v1')->group(function () use ($dev_path) {

    // Auth Routes
    include "{$dev_path}auth.php";

    // Team Routes
    include "{$dev_path}team.php";

    // Task Routes
    include "{$dev_path}task.php";

});
