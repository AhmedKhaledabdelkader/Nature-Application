<?php

use App\Http\Controllers\Apis\SponsorController;
use Illuminate\Support\Facades\Route;



Route::post('/', [SponsorController::class, 'store'])->middleware(["validate.sponsor","localize"]);

Route::post('/{id}', [SponsorController::class, 'update'])->middleware(["localize"]);