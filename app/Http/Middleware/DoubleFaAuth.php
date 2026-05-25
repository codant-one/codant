<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoubleFaAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        
        if ( !env('APP_DEBUG') && $user && $user->is_2fa !== 0 ) {
            if (!session()->has('2fa')) {
                Auth::logout();
                session()->flush();

                if(!$request->expectsJson())
                    return redirect()->route('auth.login');
            }
        }

        return $next($request);
    }
}
