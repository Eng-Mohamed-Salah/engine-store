<?php

use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix:'api/v1',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        // Add File Routing
        then: function (){
            // Route Api Admin
            Route::prefix('api/v1')
            ->group(base_path('routes/api-admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->append(ForceJsonResponse::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
