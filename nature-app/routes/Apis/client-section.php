<?php

use App\Http\Controllers\Apis\ClientSectionController;
use Illuminate\Support\Facades\Route;



Route::post('/', [ClientSectionController::class, 'store'])->middleware(["validate.client"]);

Route::post('/{id}', [ClientSectionController::class, 'update']);

Route::get('/', [ClientSectionController::class, 'index'])->middleware("validate.pagination","localize");

Route::get('search/', [ClientSectionController::class, 'search'])->middleware("validate.pagination","localize");

Route::delete('/{id}', [ClientSectionController::class, 'destroy']);