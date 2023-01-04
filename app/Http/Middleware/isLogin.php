<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isLogin
{
   
    public function handle(Request $request, Closure $next)
    {
        //cek kalau di fitur Auth ada history login, diperbolehkan akses
       if(Auth::check()) {
        return $next($request);
       }

       //kalau gak ada history login bakal dikembalikan ke halaman login dengan pesan error
       return redirect()->route('login')->with('notAllowed', 'Silahkan login terlebih dahulu!');
    }
}
