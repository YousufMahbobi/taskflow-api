<?php

use App\Http\Middleware\ForceJsonResponse;
use App\Support\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
 

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->api(prepend: [
            ForceJsonResponse::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        
        // Validation errors (422)
       $exceptions->render(function (ValidationException $e, $request) {

           if($request->expectsJson()){
               return ApiResponse::error(
                   'Validation failed',
                   'VALIDATION_ERROR',
                   $e->errors(),
                   422
               );
           }
 
       });
 
       // Model not found (404)
       $exceptions->render(function (ModelNotFoundException $e, $request) {

           if($request->expectsJson()){
               return ApiResponse::error(
                   $e->getMessage() ?: 'Resource not found',
                   'RESOURCE_NOT_FOUND',
                   [],
                   404
               );
           }
       });
 
        // HTTP exceptions (401, 403, 404, etc.)
        $exceptions->render(function (HttpExceptionInterface $e, $request) {
            
                if ($request->expectsJson()) {
                    return ApiResponse::error(
                        $e->getMessage() ?: 'HTTP error',
                        'HTTP_EXCEPTION',
                        [],
                        $e->getStatusCode()
                    );
                }
            });

    })->create();
