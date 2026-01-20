<?php

use App\Http\Controllers\Apis\ClientController;
use Illuminate\Support\Facades\Route;



Route::post('/', [ClientController::class, 'store'])->middleware(["validate.client","localize",'set.locale']);



Route::post('/{id}', [ClientController::class, 'update'])->middleware(["localize",'set.locale']);


Route::get('/', [ClientController::class, 'index'])->middleware("validate.pagination","localize");


Route::get('/{id}', [ClientController::class, 'show']);


Route::delete('/{id}', [ClientController::class, 'destroy']);