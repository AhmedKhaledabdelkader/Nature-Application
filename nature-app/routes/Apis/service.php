<?php

use App\Http\Controllers\Apis\ServiceV2Controller;
use Illuminate\Support\Facades\Route;



Route::post('/', [ServiceV2Controller::class, 'store'])->middleware(["validate.service","localize","set.locale"]);

Route::get('/show/{id}', [ServiceV2Controller::class, 'show'])->middleware(["localize"]);


Route::post('/{id}', [ServiceV2Controller::class, 'update'])->middleware(["localize","set.locale"]);


Route::delete('/{id}', [ServiceV2Controller::class, 'destroy']);

Route::get('/', [ServiceV2Controller::class, 'index'])->middleware(["validate.pagination","localize"]);

Route::get('/published-services', [ServiceV2Controller::class, 'indexPublishedServices'])->middleware(["validate.pagination","localize"]);



Route::get('/names', [ServiceV2Controller::class, 'indexPublishedServicesNames'])->middleware("localize");


/*

Route::get('/', [ProvidedServiceController::class, 'index'])->middleware("validate.pagination","localize");



*/

