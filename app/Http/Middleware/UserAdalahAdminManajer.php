<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAdalahAdminManajer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->user() ||
           !in_array($request->user()->role, ['admin', 'manajer'])) {
            return redirect('/')->with('error', 'Akses ditolak. Hanya admin dan manajer yang dapat mengakses halaman ini.');
        }
        return $next($request);
    }
}
