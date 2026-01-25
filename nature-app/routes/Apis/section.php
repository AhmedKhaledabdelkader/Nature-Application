<?php

;

use App\Http\Controllers\Apis\SectionController;
use Illuminate\Support\Facades\Route;



Route::post('/', [SectionController::class, 'store'])->middleware(["validate.section","localize","set.locale"]);



Route::post('/{id}', [SectionController::class, 'update'])->middleware(["localize","set.locale"]);


Route::get('/{id}', [SectionController::class, 'update'])->middleware(["localize"]);

