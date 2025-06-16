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
        // dd($request->user());
        $roles = explode("|", $statuses[0]);
        $user = $request->user();
        // dd(session('account'));
        // dd($allSattus);
        // dd(session('account')-);
        //     dd([
        //     'method' => $request->method(),
        //     'params' => $request->all(),
        //     'user' => $user ? $user->toArray() : null,
        //     'user_role' => $user->role ?? null,
        //     'allowed_roles' => $roles,
        // ]);
        // dd($request->all());
        // dd(!session('account') || !in_array($request->user()->role, $roles),$request->user());
        // dd($request->user(), !in_array($request->user()->status, $roles));
        // dd($request->user());
        // if($request->user()==null){

        // $user = $request->user();
        if (!$user) {
            return redirect('/Login')->with('fail', ['Akses Ditolak', 'Anda Belum Login, Silahkan login terlebih dahulu!']);
            // abort(403, 'Anda belum login.');
        }
        if (!$request->user() && !in_array($request->user()->status, $roles)) {
            abort(403, 'Anda Belum Login atau Halaman ini tidak bisa diakses oleh Role anda saat ini.');
            // }
        }

        return $next($request);
    }
}
