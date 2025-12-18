<?php

use App\Http\Controllers\Apis\ClientController;
use Illuminate\Support\Facades\Route;



Route::post('/', [ClientController::class, 'store'])->middleware(["validate.client","localize"]);



Route::post('/{id}', [ClientController::class, 'update'])->middleware(["localize"]);


Route::get('/', [ClientController::class, 'index'])->middleware("validate.pagination","localize");



Route::delete('/{id}', [ClientController::class, 'destroy']);