<?php

use App\Http\Controllers\Apis\PortfolioController;
use Illuminate\Support\Facades\Route;



Route::post('/', [PortfolioController::class, 'store'])->middleware(["validate.portfolio"]);

Route::get('/',[PortfolioController::class, 'show']) ;

Route::delete('/',[PortfolioController::class, 'destroy']) ;


Route::post('/update', [PortfolioController::class, 'update'])->middleware(["validate.portfolio"]);