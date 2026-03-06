<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Admin has access to everything for convenience, or we exact-match the role
        if ($user->role === 'admin' || $user->role === $role) {
            return $next($request);
        }

        // If a client tries to access a vendor route, send to client dashboard
        if ($user->role === 'client') {
            return redirect()->route('client.dashboard');
        }

        // If a vendor tries to access a client route, send to vendor dashboard
        if ($user->role === 'vendor') {
            return redirect()->route('dashboard');
        }

        abort(403, 'Unauthorized Access');
    }
}
