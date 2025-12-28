<?php

use App\Http\Controllers\Apis\CityController;
use Illuminate\Support\Facades\Route;



Route::post('/', [CityController::class, 'store'])->middleware(["validate.city","localize","set.locale"]);

Route::get('/country/{countryId}', [CityController::class, 'index'])->middleware("validate.pagination","localize");

Route::get('/{id}', [CityController::class, 'show'])->middleware("localize");

Route::post('/{id}', [CityController::class, 'update'])->middleware(["localize","set.locale"]);

Route::delete('/{id}', [CityController::class, 'destroy']);


