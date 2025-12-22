

<?php

use App\Http\Controllers\Apis\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [UserController::class, 'register'])->middleware(["validate.user"]);

Route::post('/signin', [UserController::class, 'login'])->middleware(["validate.userAuth"]);


Route::get('/email/verify/{id}/{hash}', [UserController::class, 'verify'])
    ->middleware('signed')
    ->name('verification.verify');
