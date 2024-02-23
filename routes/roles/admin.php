<?php

use App\Http\Controllers\Map\DistrictController;
use App\Http\Controllers\Map\IrrigationListController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Map\IrrigationSectionController;
use App\Http\Controllers\Map\SubDistrictController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\UserController;

Route::prefix('map')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('sub-district', [SubDistrictController::class, 'index']);
    Route::get('sub-district/{id}', [SubDistrictController::class, 'show']);
    Route::get('district', [DistrictController::class, 'index']);
    Route::get('district/{id}', [DistrictController::class, 'show']);
    Route::get('irrigations', [IrrigationListController::class, 'index']);
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
