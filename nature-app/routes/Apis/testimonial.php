<?php

use App\Http\Controllers\Apis\TestimonialController;
use Illuminate\Support\Facades\Route;



Route::post('/', [TestimonialController::class, 'store'])->middleware(["validate.testimonial","localize","set.locale"]);


Route::post('/{id}', [TestimonialController::class, 'update'])->middleware(["localize","set.locale"]);


Route::get('/', [TestimonialController::class, 'index'])->middleware(["localize"]);


Route::get('/{id}', [TestimonialController::class, 'show'])->middleware(["localize"]);

