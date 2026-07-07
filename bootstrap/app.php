<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        channels: __DIR__ . '/../routes/channels.php',
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // $middleware->alias([
        //     'role' => \App\Http\Middleware\RoleMiddleware::class,
        // ]);

        // ✅ Middleware untuk API (Sanctum)
        // $middleware->api([
        //    EnsureFrontendRequestsAreStateful::class,
        //]);

        $middleware->api([
            // Pastikan API selalu JSON → hindari redirect ke login
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class,
            EnsureFrontendRequestsAreStateful::class,
            \App\Http\Middleware\ForceJsonResponse::class, // ← tambahkan!
        ]);


        /** @noinspection PhpUndefinedClassInspection */
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, $request) {
            if ($e->getStatusCode() === 403) {
                return redirect()->route('dashboard');
            }
        });

        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            // Jika request API → kembalikan JSON
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Unauthenticated.'
                ], 401);
            }

            // Default fallback (web)
            //return redirect()->guest('/login');

            // Request web biasa
            return redirect()
                ->route('login')
                ->with('error', 'Session habis, silakan login ulang.');
        });
    })->create();
