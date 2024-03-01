<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->status == 'ban') {
            Auth::logout();
            return redirect('/login')->withErrors(['lock' => 'Your account is locked']);
        } else if (Auth::user()->status == 'admin') {
            return $next($request);
        }
        return redirect('/');
    }
}
