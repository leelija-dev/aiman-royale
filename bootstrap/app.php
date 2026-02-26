<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web:[ __DIR__.'/../routes/admin.php',
        __DIR__.'/../routes/web.php'], 
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'prevent.back.history' => \App\Http\Middleware\PreventBackHistory::class,
            'guest.admin' => \App\Http\Middleware\RedirectIfAuthenticatedAdmin::class,
           'check.login' => \App\Http\Middleware\CheckUserLogin::class,
        ]);

        // Ensure index.php paths are redirected to clean URLs in all environments
        $middleware->appendToGroup('web', [
            \App\Http\Middleware\RedirectIndexPhp::class,
            \App\Http\Middleware\DynamicSeoMiddleware::class,
             
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
         // Handle 404 errors and redirect to custom 404 page
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Page not found'], 404);
            }
            
            return response()->view('web.404', [], 404);
        });
    })->create();
