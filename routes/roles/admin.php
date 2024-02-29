<?php

use App\Http\Controllers\Content\ArticleController;
use App\Http\Controllers\Content\ComplaintController;
use App\Http\Controllers\Map\DistrictController;
use App\Http\Controllers\Map\IrrigationListController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Map\SubDistrictController;
use App\Http\Controllers\Report\ReportListController;
use App\Http\Controllers\UploadDump\UploadDumpController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\UserController;

Route::prefix('map')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('sub-district', [SubDistrictController::class, 'index']);
    Route::get('sub-district/{id}', [SubDistrictController::class, 'show']);
    Route::get('district', [DistrictController::class, 'index']);
    Route::get('district/{id}', [DistrictController::class, 'show']);
    Route::get('irrigations', [IrrigationListController::class, 'index']);
    Route::get('irrigations/{id}', [IrrigationListController::class, 'show']);
});

Route::prefix('roles')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [RoleController::class, 'index']);
    Route::get('/{id}', [RoleController::class, 'show']);
    Route::post('', [RoleController::class, 'store']);
    Route::put('/{id}', [RoleController::class, 'update']);
    Route::delete('/{id}', [RoleController::class, 'destroy']);
    Route::delete('', [RoleController::class, 'deleteAll']);
});

Route::prefix('users')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('', [UserController::class, 'store']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
    Route::delete('change-password/{id}', [UserController::class, 'change_password']);
});

Route::prefix('article')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [ArticleController::class, 'index']);
    Route::get('/{id}', [ArticleController::class, 'show']);
    Route::post('', [ArticleController::class, 'store']);
    Route::put('/{id}', [ArticleController::class, 'update']);
    Route::delete('/{id}', [ArticleController::class, 'destroy']);
});

Route::prefix('complaint')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [ComplaintController::class, 'index']);
    Route::get('/{id}', [ComplaintController::class, 'show']);
    Route::post('', [ComplaintController::class, 'store']);
    Route::put('/{id}', [ComplaintController::class, 'update']);
    Route::delete('/{id}', [ComplaintController::class, 'destroy']);
});

Route::prefix('upload-dumps')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [UploadDumpController::class, 'index']);
    Route::get('/{id}', [UploadDumpController::class, 'show']);
    Route::post('', [UploadDumpController::class, 'store']);
    Route::put('/{id}', [UploadDumpController::class, 'update']);
    Route::delete('/{id}', [UploadDumpController::class, 'destroy']);
});

Route::prefix('report-list')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [ReportListController::class, 'index']);
    Route::get('/{id}', [ReportListController::class, 'show']);
    Route::post('', [ReportListController::class, 'store']);
    Route::put('/{id}', [ReportListController::class, 'update']);
    Route::delete('/{id}', [ReportListController::class, 'destroy']);
});
