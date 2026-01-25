<?php


use Illuminate\Support\Facades\Route;






Route::prefix('countries')->group(base_path('routes/apis/country.php'));

Route::prefix('cities')->group(base_path('routes/apis/city.php'));

Route::prefix('awards')->group(base_path('routes/apis/award.php'));

Route::prefix('sponsors')->group(base_path('routes/apis/sponsor.php'));

Route::prefix('clients')->group(base_path('routes/apis/client-section.php'));

Route::prefix('services')->group(base_path('routes/apis/service.php'));

Route::prefix('projects')->group(base_path('routes/Apis/project.php'));

Route::prefix('steps')->group(base_path('routes/Apis/step.php'));

Route::prefix('portfolios')->group(base_path('routes/Apis/portfolio.php'));

Route::prefix('users')->group(base_path('routes/Apis/user.php'));

Route::prefix('testimonials')->group(base_path('routes/Apis/testimonial-section.php'));

Route::prefix('sections')->group(base_path('routes/Apis/section.php'));

Route::prefix('project_metrics')->group(base_path('routes/Apis/project_metric.php'));

Route::prefix('media')->group(base_path('routes/Apis/media.php'));