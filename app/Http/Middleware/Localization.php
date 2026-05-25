<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization
{
    /**
     * Handle an incoming request.
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        App::setLocale('es');

        if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        }
        
        /* Set new lang with the use of session */
        if (session()->has('lang')) {
            App::setLocale(session()->get('lang'));
        }

        return $next($request);
    }
}