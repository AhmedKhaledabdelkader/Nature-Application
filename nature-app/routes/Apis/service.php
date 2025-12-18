<?php

use App\Http\Controllers\Apis\ProvidedServiceController;
use Illuminate\Support\Facades\Route;



Route::post('/', [ProvidedServiceController::class, 'store'])->middleware(["validate.service","localize"]);



Route::post('/{id}', [ProvidedServiceController::class, 'update'])->middleware(["localize"]);


Route::get('/', [ProvidedServiceController::class, 'index'])->middleware("validate.pagination","localize");


Route::get('/{id}', [ProvidedServiceController::class, 'show'])->middleware(["localize"]);

Route::delete('/{id}', [ProvidedServiceController::class, 'destroy']);