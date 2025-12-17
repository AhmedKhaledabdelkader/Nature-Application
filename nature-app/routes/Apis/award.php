<?php

use App\Http\Controllers\Apis\AwardController;
use Illuminate\Support\Facades\Route;


Route::post('/', [AwardController::class, 'store'])->middleware(["validate.award","localize"]);

Route::post('/{id}', [AwardController::class, 'update'])->middleware(["localize"]);

Route::get('/', [AwardController::class, 'index'])->middleware("localize");

