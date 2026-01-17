<?php

use App\Http\Controllers\Apis\TestimonialController;
use App\Http\Controllers\Apis\TestimonialSectionController;
use Illuminate\Support\Facades\Route;



Route::post('/', [TestimonialSectionController::class, 'store'])->middleware(["validate.testimonial"]);


Route::post('/{id}', [TestimonialSectionController::class, 'update']);


Route::get('/', [TestimonialSectionController::class, 'index'])->middleware(["validate.pagination","localize"]);


Route::get('search/', [TestimonialSectionController::class, 'search'])->middleware("validate.pagination","localize");

Route::delete('/{id}', [TestimonialSectionController::class, 'destroy']);
