<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->prepend(\App\Http\Middleware\AlwaysAcceptJson::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $isProduction = app()->isProduction();
        $exceptions->render(function (Throwable $e) use ($isProduction) {
            if ($e instanceof NotFoundHttpException) {
                $statusCode = $isProduction ? 401 : 404;
            }
            return response()->json([
                'message' => $isProduction ? 'Unauthorized' : 'Resource not found.',
                'error' => $isProduction ? 'Unauthorized' : $e->getMessage(),
            ], $statusCode);
        });
    })->create();
