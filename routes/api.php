<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use app\Http\Controllers\AppController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/all-segments', [AppController::class, 'all_segment']);

Route::post('/report', [AppController::class, 'report']);

Route::get('/segments-by-user-id', [AppController::class, 'segments_by_user_id']);

Route::get('/user-data', [AppController::class, 'user_data']);