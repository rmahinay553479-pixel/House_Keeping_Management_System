<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Session::has('authenticated')) {
            return redirect('/login');
        }

        $user = Session::get('user');

        if (!$user || $user['role'] !== $role) {
            return response('Unauthorized', 403);
        }

        return $next($request);
    }
}
