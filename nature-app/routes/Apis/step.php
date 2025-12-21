<?php

use App\Http\Controllers\Apis\StepController;
use Illuminate\Support\Facades\Route;



Route::post('/services/{service}', [StepController::class, 'store'])->middleware(["validate.step","localize"]);

Route::post('/', [StepController::class, 'update'])->middleware(['localize']);

    Route::delete('/', [StepController::class, 'destroy']);



