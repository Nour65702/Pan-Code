<?php

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




$dev_path = __DIR__ . '../PanCode/v1/';

Route::prefix('v1')->group(function () use ($dev_path) {

    // Auth Routes
    include "{$dev_path}auth.php";

    // Team Routes
    include "{$dev_path}team.php";

    // Task Routes
    include "{$dev_path}task.php";

});
