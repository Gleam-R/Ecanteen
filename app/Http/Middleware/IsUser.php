<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Memeriksa apakah pengguna sudah login dan memiliki peran user
        if (Auth::check() && Auth::user()->role === 'user') {
            return $next($request); // Izinkan akses jika user
        }

        // Jika bukan user, redirect atau abort
        return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');    }
}
