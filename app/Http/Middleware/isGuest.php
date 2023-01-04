<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isGuest
{
  
    public function handle(Request $request, Closure $next)
    {
         if(Auth::check()) {
            //kalau gak ada history login bakal dikembalikan ke halaman login dengan pesan error
           return redirect()->route('project.index')->with('notAllowed', 'Anda sudah login!');
           }
           return $next($request);      
    }
}
