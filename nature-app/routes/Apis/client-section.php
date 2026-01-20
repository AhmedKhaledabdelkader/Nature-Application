<?php

use App\Http\Controllers\Apis\ClientSectionController;
use Illuminate\Support\Facades\Route;



Route::post('/', [ClientSectionController::class, 'store'])->middleware(["validate.client","auth.user"]);

Route::post('/{id}', [ClientSectionController::class, 'update'])->middleware(['auth.user']);

Route::get('/', [ClientSectionController::class, 'search'])->middleware("validate.pagination","localize");

//Route::get('search/', [ClientSectionController::class, 'search'])->middleware("validate.pagination","localize");

Route::delete('/{id}', [ClientSectionController::class, 'destroy']);


Route::get('/{id}', [ClientSectionController::class, 'show']);