<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request)
    {
        // Check if user exists including trashed
        $user = \App\Models\User::withTrashed()->where('email', $request->email)->first();

        if ($user && $user->trashed()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                $this->username() => ['Tu cuenta ha sido eliminada y no puedes iniciar sesión.'],
            ]);
        }

        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }
}
