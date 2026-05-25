<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLogin;

class CheckSessionStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Solo verificar si hay una sesión completamente establecida (después de 2FA)
        if (Auth::check() && session()->has('login') && session()->get('login') === 'admin') {
            $currentSessionId = session()->getId();
            $userId = Auth::id();

            // Solo verificar si existe un UserLogin con este session_id
            $loginExists = UserLogin::where('user_id', $userId)
                ->where('session_id', $currentSessionId)
                ->where('is_active', true)
                ->exists();

            // Si no existe un login activo con este session_id, la sesión fue cerrada remotamente
            if (!$loginExists) {
                Auth::logout();
                session()->flush();
                session()->invalidate();
                session()->regenerateToken();

                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Tu sesión ha sido cerrada desde otro dispositivo.',
                        'redirect' => route('auth.login')
                    ], 401);
                }

                return redirect()->route('auth.login')
                    ->with('session_expired', 'Tu sesión ha sido cerrada desde otro dispositivo.');
            }
        }

        return $next($request);
    }
}
