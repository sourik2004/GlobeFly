<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Allow administrator to access everything, otherwise verify exact role
        if ($request->user()->role !== 'admin' && $request->user()->role !== $role) {
            abort(403, 'Unauthorized access. You do not have the required permissions.');
        }

        return $next($request);
    }
}
