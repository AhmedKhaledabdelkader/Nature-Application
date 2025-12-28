<?php

use App\Http\Controllers\Apis\SponsorController;
use Illuminate\Support\Facades\Route;



Route::post('/', [SponsorController::class, 'store'])->middleware(["validate.sponsor","localize","set.locale"]);

Route::post('/{id}', [SponsorController::class, 'update'])->middleware(["localize","set.locale"]);

Route::get('/', [SponsorController::class, 'index'])->middleware(["localize"]);


Route::delete('/{id}', [SponsorController::class, 'destroy']);

