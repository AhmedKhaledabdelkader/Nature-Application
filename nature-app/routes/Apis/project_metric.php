<?php

use App\Http\Controllers\Apis\ProjectMetricController;
use Illuminate\Support\Facades\Route;


Route::post('/', [ProjectMetricController::class, 'store'])->middleware(["validate.projectMetric","localize","set.locale"]);

Route::post('/{id}', [ProjectMetricController::class, 'update'])->middleware(["localize","set.locale"]);

Route::get('/', [ProjectMetricController::class, 'index'])->middleware(["localize"]);

Route::delete('/{id}', [ProjectMetricController::class, 'destroy']);



