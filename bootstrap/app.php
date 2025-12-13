<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register middleware alias
        $middleware->alias([
            'CheckAdmin' => \App\Http\Middleware\CheckAdmin::class,
            'CheckUser' => \App\Http\Middleware\CheckUser::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
