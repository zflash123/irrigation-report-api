<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Map\IrrigationSectionController;
use App\Http\Controllers\Map\SubDistrictController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\UserController;

Route::prefix('map')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('sub-district', [SubDistrictController::class, 'index']);
    Route::get('sub-district/{id}', [SubDistrictController::class, 'show']);
    Route::get('section', [IrrigationSectionController::class, 'index']);
});

Route::prefix('roles')->middleware(['api', 'auth:api'])->group(function () {
    Route::get('', [RoleController::class, 'index']);
    Route::get('/{id}', [RoleController::class, 'show']);
    Route::post('', [RoleController::class, 'store']);
    Route::put('/{id}', [RoleController::class, 'update']);
    Route::delete('/{id}', [RoleController::class, 'destroy']);
    Route::delete('', [RoleController::class, 'deleteAll']);
});
