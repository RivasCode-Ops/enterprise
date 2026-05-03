<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin.role' => \App\Http\Middleware\EnsureUserIsAdmin::class,
        ]);

        $middleware->redirectTo(
            guests: function () {
                $path = request()->path();
                if ($path === 'admin' || str_starts_with($path, 'admin/')) {
                    return route('admin.login');
                }

                return route('broker.login');
            },
            users: function () {
                if (Auth::guard('admin')->check()) {
                    return route('admin.dashboard');
                }
                if (Auth::guard('broker')->check()) {
                    return route('broker.properties.index');
                }

                return route('home');
            },
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
