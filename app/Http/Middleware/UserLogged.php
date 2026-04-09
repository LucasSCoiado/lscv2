<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserLogged
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!session('user')){
            return redirect('/login');
        }

        if (!Auth::check() && session('user')) {
            $sess = session('user');
            $userId = is_array($sess) && isset($sess['id']) ? $sess['id'] : $sess;
            if ($userId) {
                Auth::loginUsingId($userId);
            }
        }

        return $next($request);
    }
}
