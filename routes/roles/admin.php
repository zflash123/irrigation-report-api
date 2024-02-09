<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Map\IrrigationSectionController;

Route::prefix('map')->middleware('api')->group(function () {
    Route::get('section', [IrrigationSectionController::class, 'index']);
});
