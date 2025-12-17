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
            ], 500);
        });


    })->create();
