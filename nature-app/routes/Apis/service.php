<?php

use App\Http\Controllers\Apis\ProvidedServiceController;
use App\Http\Controllers\ServiceV2Controller;
use Illuminate\Support\Facades\Route;



Route::post('/', [ServiceV2Controller::class, 'store'])->middleware(["validate.service","localize","set.locale"]);

Route::get('/{id}', [ServiceV2Controller::class, 'show'])->middleware(["localize"]);


Route::post('/{id}', [ServiceV2Controller::class, 'update'])->middleware(["localize","set.locale"]);



Route::delete('/{id}', [ServiceV2Controller::class, 'destroy']);

/*

Route::get('/', [ProvidedServiceController::class, 'index'])->middleware("validate.pagination","localize");


Route::get('/names', [ProvidedServiceController::class, 'getAllServicesNames'])->middleware("localize");


*/

