<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Middleware untuk membatasi akses API berdasarkan role user.
 *
 * Cara pakai di route:
 *   Route::middleware(['auth:sanctum', 'api.role:user'])
 *
 * Registrasikan di bootstrap/app.php (Laravel 11):
 *   ->withMiddleware(function (Middleware $middleware) {
 *       $middleware->alias(['api.role' => \App\Http\Middleware\ApiRoleMiddleware::class]);
 *   })
 *
 * Atau di app/Http/Kernel.php (Laravel 10) di $routeMiddleware:
 *   'api.role' => \App\Http\Middleware\ApiRoleMiddleware::class,
 */
class ApiRoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        if (!in_array($user->role, $roles)) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Role Anda tidak diizinkan.',
            ], 403);
        }

        return $next($request);
    }
}
