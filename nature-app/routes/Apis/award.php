<?php

use App\Http\Controllers\Apis\AwardController;
use Illuminate\Support\Facades\Route;


Route::post('/', [AwardController::class, 'store'])->middleware(["validate.award","localize","set.locale"]);

Route::post('/{id}', [AwardController::class, 'update'])->middleware(["localize","set.locale"]);

Route::get('/', [AwardController::class, 'index'])->middleware(["validate.pagination","localize"]);

Route::get('/{id}', [AwardController::class, 'show'])->middleware("localize");

Route::delete('/{id}', [AwardController::class, 'destroy']);

