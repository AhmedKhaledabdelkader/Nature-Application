<?php


use Illuminate\Support\Facades\Route;






Route::prefix('countries')->group(base_path('routes/apis/country.php'));

Route::prefix('cities')->group(base_path('routes/apis/city.php'));

Route::prefix('awards')->group(base_path('routes/apis/award.php'));

Route::prefix('sponsors')->group(base_path('routes/apis/sponsor.php'));

Route::prefix('clients')->group(base_path('routes/apis/client.php'));

Route::prefix('services')->group(base_path('routes/apis/service.php'));

Route::prefix('media')->group(base_path('routes/Apis/media.php'));