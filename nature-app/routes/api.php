<?php


use Illuminate\Support\Facades\Route;






Route::prefix('countries')->group(base_path('routes/apis/country.php'));

Route::prefix('cities')->group(base_path('routes/apis/city.php'));


Route::prefix('awards')->group(base_path('routes/apis/award.php'));

Route::prefix('media')->group(base_path('routes/Apis/media.php'));