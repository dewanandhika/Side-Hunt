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
        // dd($roles);
        $user = $request->user();
        // dd(session('account'));
        // dd($allSattus);
        // dd(session('account')-);
        //     dd([
        //     'method' => $request->method(),
        //     'path' => $request->path(),
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
        // dd($request->user()->role);
        // $user = $request->user();
        // dd($request->path());
        // dd(in_array($request->user()->status, $roles));
        // dd((in_array($request->path(), ['user/preferensi/save', 'question-new-user'])));
        if (!$user) {
            return redirect('/Login')->with('fail', ['Akses Ditolak', 'Anda Belum Login, Silahkan login terlebih dahulu!']);
            // abort(403, 'Anda belum login.');
        }
        else if (!in_array($request->user()->role, $roles)) {
            // return redirect('/')->with('fail',['AKSES DITOLAK!','Halaman ini']);
            abort(403, 'Halaman ini tidak bisa diakses oleh Role anda saat ini');
        }
        else if(session('account')!='admin' && (!in_array($request->path(), ['user/preferensi/save', 'question-new-user']))){
            if(session('account')['preferensi_user']==null){
                return redirect('/question-new-user');
            }
        }
        // dd('udh masuk');
        return $next($request);
    }
}
