<?php

use App\Http\Controllers\Apis\CountryController;
use Illuminate\Support\Facades\Route;



Route::post('/', [CountryController::class, 'store'])->middleware(["validate.country","localize"]);

Route::get('/{id}', [CountryController::class, 'show'])->middleware("localize");

Route::get('/', [CountryController::class, 'index'])->middleware("validate.pagination","localize");

Route::post('/{id}', [CountryController::class, 'update'])->middleware(["localize"]);

Route::delete('/{id}', [CountryController::class, 'destroy']);






