
<?php

use App\Http\Controllers\Apis\ProjectController;
use Illuminate\Support\Facades\Route;



Route::post('/', [ProjectController::class, 'store'])->middleware(["validate.project","localize"]);



Route::post('/{id}', [ProjectController::class, 'update'])->middleware(["localize"]);


Route::get('/', [ProjectController::class, 'index'])->middleware("validate.pagination","localize");


Route::get('/{id}', [ProjectController::class, 'show'])->middleware(["localize"]);


Route::delete('/{id}', [ProjectController::class, 'destroy']);