<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Map\IrrigationSectionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\ProfileController;

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

Route::post('/register', [UserController::class, 'register']);

Route::post('/login', [UserController::class, 'login']);

Route::post('/reset-password', [UserController::class, 'reset_password']);

Route::group(['middleware' => ['normal.user:api']], function() {
    Route::get('/close-segments', [AppController::class, 'close_segments']);
    Route::post('/report', [ReportController::class, 'create_report']);
    Route::get('/report/{id}', [ReportController::class, 'report_by_id']);
    Route::get('/user-reports', [ReportController::class, 'reports_by_user_id']);
    Route::get('/segments-by-user-id', [AppController::class, 'segments_by_user_id']);
    Route::get('/profile', [ProfileController::class, 'show_profile']);
    Route::put('/profile', [ProfileController::class, 'edit_profile']);
    Route::get('/check-valid-cookie', [AppController::class, 'check_valid_cookie']);
});

Route::prefix('auth')->middleware('api')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::get('login', function () {
    return response()->json([
        'statusCode' => 401,
        'message' => 'Invalid Token',
        'errors' => 'E_UNAUTHORIZED_ACCESS'
    ], 401);
})->name('login');

include __DIR__ . '/roles/admin.php';
