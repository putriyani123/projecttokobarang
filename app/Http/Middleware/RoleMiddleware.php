<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userRole = Auth::user()->role ?? 'user';

        if ($userRole !== $role) {
            if ($userRole === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($userRole === 'kurir') {
                return redirect('/kurir/dashboard');
            }
            return redirect('/user/dashboard');
        }

        return $next($request);
    }
}
