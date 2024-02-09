<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Map\IrrigationSectionController;
use App\Http\Controllers\Map\SubDistrictController;

Route::prefix('map')->middleware('api')->group(function () {
    Route::get('sub-district', [SubDistrictController::class, 'index']);
    Route::get('sub-district/{id}', [SubDistrictController::class, 'show']);
    Route::get('section', [IrrigationSectionController::class, 'index']);
});
