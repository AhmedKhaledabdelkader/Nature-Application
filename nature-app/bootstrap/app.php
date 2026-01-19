<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
         $middleware->alias([
 
            'localize'=>\App\Http\Middleware\LocalizationMiddleware::class,
            'validate.country'=>\App\Http\Middleware\ValidateCountry::class,
            'validate.pagination' => \App\Http\Middleware\ValidatePaginationMiddleware::class,
            'validate.city'=>\App\Http\Middleware\ValidateCity::class,
            'validate.award'=>\App\Http\Middleware\ValidateAward::class,
            'validate.sponsor'=>\App\Http\Middleware\ValidateSponsor::class,
             'validate.client'=>\App\Http\Middleware\ValidateClient::class,
             'validate.service'=>\App\Http\Middleware\ValidateService::class,
             'validate.project'=>\App\Http\Middleware\ValidateProject::class,
             'validate.step'=>\App\Http\Middleware\ValidateStep::class,
             'validate.portfolio'=>\App\Http\Middleware\ValidatePortfolioFile::class,
             'validate.user'=>\App\Http\Middleware\ValidateUser::class,
             'validate.userAuth'=>\App\Http\Middleware\ValidateUserAuth::class,
             'validate.testimonial'=>\App\Http\Middleware\ValidateTestimonial::class,
              'auth.user'=> \App\Http\Middleware\AuthenticationMiddleware::class,
              'admin.user'=>\App\Http\Middleware\AdminMiddleware::class,
               'set.locale'=>\App\Http\Middleware\SetLocale::class,
            'validate.projectMetric'=>\App\Http\Middleware\ValidateProjectMetric::class,

             




             
        ]);






    })
    ->withExceptions(function (Exceptions $exceptions) {

         $exceptions->render(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Route not found'
            ], 404);
        });

     
        $exceptions->render(function (Throwable $e, $request) {
    return response()->json([
        'status'  => 'error',
        'message' => $e->getMessage(),
        'file'    => $e->getFile(),
        'line'    => $e->getLine(),
        'trace'   => $e->getTrace(), // optional, full stack trace
    ], 500);
});



    })->create();
