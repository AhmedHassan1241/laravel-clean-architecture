<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        apiPrefix: '/',

    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias(["IsAdmin" => IsAdmin::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //

    })
    ->create();
