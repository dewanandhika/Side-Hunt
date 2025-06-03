<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMidleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$statuses): Response
    {
        // dd(session('account'));
        if (!$request->user() || !in_array($request->user()->status, $statuses)) {
            abort(403, 'Akses ditolak. Status tidak valid.');
        }

        return $next($request);
    }
}
