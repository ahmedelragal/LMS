<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role = null): Response
    {

        $user = Auth::guard('admin')->user();

        if (!$user) {
            return redirect('/login'); 
        }
        if ($role && $user->role !== $role) {
            return redirect('/unauthorized'); 
        }
        return $next($request);
    }
}
