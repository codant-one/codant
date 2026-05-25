<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;

use App\Models\Country;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Gender;

use Carbon\Carbon;
use File;
use Validator;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Check if user exists and is deleted
        $user = User::withTrashed()->where('email', $request->email)->first();
        
        if ($user && $user->trashed()) {
            return redirect()->route('auth.login')->with([
                'account_deleted' => true
            ]);
        }

        if (Auth::attempt($credentials)) {
            // IMPORTANTE: Regenerar sesión PRIMERO antes de guardar el session_id
            $request->session()->regenerate();
            
            $user = Auth::user();
            $user->online = Carbon::now();
            $user->save();

            // historial de logins
            $agent = new Agent();  
            $deviceType = "";

            if( $agent->isMovile() )
                $deviceType = "Movile";
            elseif( $agent->isPhone() )
                $deviceType = "Phone";
            elseif( $agent->isTable() )
                $deviceType = "Table";
            elseif( $agent->isDesktop() )
                $deviceType = "Desktop";

            $device = $deviceType .': '. $agent->device();
            $plataform = $agent->platform();
            $plataform.= ' ' . $agent->version($plataform);
            $browser = $agent->browser();
            $browser.= ' ' . $agent->version($browser);
            $is_bot = $agent->isRobot();
            $ip = ($request->has("ip") && !empty($request->ip)) ? $request->ip : $request->ip();
            $location = file_get_contents('http://ipinfo.io/'.$ip.'/geo');

            if (!empty($location)){
                $json = json_decode($location, true);
                $location = isset($json['country']) ? $json['country'].' - '.$json['region'].' - '.$json['city'] : 'Local';
            }
            
            // Crear nuevo registro de login con el session_id DESPUÉS de regenerar
            // NO marcamos sesiones anteriores como inactivas para permitir múltiples sesiones simultáneas
            $userLogin = new UserLogin;
            $userLogin->user_id = Auth::user()->id;
            $userLogin->device = $device;
            $userLogin->plataform = $plataform;
            $userLogin->browser = $browser;
            $userLogin->is_bot = $is_bot;
            $userLogin->ip = $ip;
            $userLogin->location = $location;
            $userLogin->session_id = session()->getId(); // Obtener el session_id DESPUÉS de regenerate()
            $userLogin->is_active = true;
            $userLogin->save();

            if (env('APP_DEBUG') || ($user->is_2fa === 0)) {
                session()->put('2fa', '0');
                session()->put('login', 'admin');
                return redirect()->route('admin.dashboard.index');
            }

            if (empty($user->token_2fa)) {
                $google2fa = app('pragmarx.google2fa');
                $token = $google2fa->generateSecretKey();

                $user->token_2fa = $token;
                $user->update();

                $request->session()->flash('user', $user);

                return redirect()->route('auth.2fa.generate');
            } else {
                return redirect(route('auth.2fa'));
            }
        }

        return redirect()->route('auth.login')->withErrors([
            'email' => 'Las credenciales no coindicen.',
        ]);
    }

    public function login(Request $request)
    {
        if (Auth::check() && session()->get('login') === 'admin')
            return redirect()->route('admin.dashboard.index');

        return view('admin.auth.login');
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();

        return redirect()->route('auth.login');
    }

    public function validate_double_factor_auth(Request $request)
    {
        try {
            $user = auth()->user();
            $google2fa = app('pragmarx.google2fa');
            
            // Limpiar el token de cualquier guión o formato
            $token_2fa = str_replace('-', '', $request->token_2fa);

            if ($google2fa->verifyKey($user->token_2fa, $token_2fa)) {
                session()->put('2fa', '1');
                session()->put('login', 'admin');

                if($request->panel) {
                    $user->is_2fa =  ($user->is_2fa === 0) ? 1 : 0;
                    $user->update();

                    return redirect()->route('profile')->with([
                        'register_success_2fa' => '¡Autenticación de dos factores '.($user->is_2fa === 1 ? 'habilitada' : 'deshabilitada').'!',
                        'text_2fa' => 'La autenticación de dos factores (2FA) se ha '.($user->is_2fa === 1 ? 'habilitado' : 'deshabilitado').' correctamente.'
                    ]);
                }

                return redirect()->route('admin.dashboard.index');
            }

            // Asegurar que la ruta existe, sino usar auth.2fa por defecto
            $routeName = $request->route ?? 'auth.2fa';
            
            return redirect()->route($routeName)->with([
                'register_error' => 'Código de verificación incorrecto',
                'text' => 'Verifique nuevamente'
            ]);
        } catch (\Exception $e) {
            $routeName = $request->route ?? 'auth.2fa';
            
            return redirect()->route($routeName)->with([
                'register_error' => 'Error',
                'text' => $e->getMessage()
            ]);
        }
    }

    public function generate_double_factor_auth()
    {
        $google2fa = app('pragmarx.google2fa');

        $user = auth()->user();
        $token = $user->token_2fa;

        $qr = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $token
        );

        // Si es una petición AJAX, retornar JSON
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'qr' => $qr,
                'token' => $token
            ]);
        }

        return view('admin.auth.generate-2fa', 
            compact(
                'user', 
                'qr', 
                'token'
            )
        );
    }

    public function double_factor_auth()
    {
        $user = auth()->user();
        $token = $user->token_2fa;

        if (auth()->check() && session()->has('2fa'))
            return redirect()->route('admin.dashboard.index');

        return view('admin.auth.2fa', compact('user'));
    }

    public function profile() {

        $gendersActives = Gender::forDropdownByStates(['2']);

        $profileCompletenessCount = 4;

        if(isset(auth()->user()->userDetail->gender_id))
            $profileCompletenessCount++;
        if(isset(auth()->user()->userDetail->address_id))
            $profileCompletenessCount++;
        if(isset(auth()->user()->userDetail->phone))
            $profileCompletenessCount++;
        if(isset(auth()->user()->userDetail->birthday))
            $profileCompletenessCount++;
        if(isset(auth()->user()->userDetail->address->address))
            $profileCompletenessCount++;
        if(isset(auth()->user()->userDetail->address->postal_code))
            $profileCompletenessCount++;

        $profileCompletenessPercentage = ($profileCompletenessCount*100)/10;
        $countriesActives = Country::forDropdownByStates(['2']);//Actives Countries
        $countriesPhoneCodes = Country::phonePrefix();
        $countriesDetails = Country::with(['state'])->get()->toArray();
        $countries = Country::forDropdown();

        $google2fa = app('pragmarx.google2fa');
        $user = auth()->user();  

        if (empty($user->token_2fa)) {
            $token = $google2fa->generateSecretKey();
            $user->token_2fa = $token;
            $user->update();
        } else {
            $token = $user->token_2fa;
        }

        $qr = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $token
        );

        // Obtener TODAS las sesiones activas del usuario (sin withTrashed para mostrar solo activas)
        $userLogins = UserLogin::where('user_id', $user->id)
                                   ->where('is_active', true)
                                   ->orderBy('created_at', 'desc')
                                   ->get();

        return view('admin.auth.profile',
            compact(
                'qr',
                'token',
                'profileCompletenessPercentage',
                'countries',
                'countriesActives',
                'countriesPhoneCodes',
                'countriesDetails',
                'gendersActives',
                'userLogins'
            )
        );
    }

    public function profileStore(Request $request) {
        //Si existe la propiedad.
        if ($request->has("country_id")){
            $country = Country::find($request->country_id);
            if ($country) {
                $request->merge([
                    "phone" => '+' . $country->phonecode . $request->phone
                ]);
            }
        }

        $user = User::find(auth()->user()->id);
        $user->firstname = $request->firstname;
        $user->secondname = $request->secondname;
        $user->lastname = $request->lastname;
        $user->secondsurname = $request->secondsurname;
        $user->full_profile = 1;
        $user->update();
        $user->userDetail()->delete();
        
        $address = $user->createOrUpdateAddress($request);
        $user->createOrUpdateUserDetails($request, $address);

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $path = 'avatars/';

            $file_data = uploadFile($image, $path, $user->avatar);

            $user->avatar = $file_data['filePath'];
            $user->update();
        } 

        return redirect()->route("profile")->with([
            'register_success' => '¡Datos actualizados!',
            'text' => 'Tu información personal ha sido actualizada exitosamente'
        ]);
        
    }

    public function updatePassword(Request $request){

        $validate = Validator::make($request->all(),
            [ 'current_password' => 'required|current_password' ],
            [ 'current_password.current_password' => 'La contraseña actual no coincide' ]
        ); 

        if($validate->fails()){
            return redirect()->route("profileStore")->with([
                'register_error' => 'Error',
                'text' => $validate->errors()->first()
            ]);
        } 

        $user = User::find(auth()->user()->id);
        $user->password = Hash::make($request->new_password);
        $user->update();

        return redirect()->route("profileStore")->with([
            'register_success' => '¡Enhorabuena!',
            'text' => 'La contraseña ha sido actualizada'
        ]);
        
    }

    public function updateAvatar(Request $request) {

        $user = User::find(auth()->user()->id);

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');

            $path = 'avatars/';

            $file_data = uploadFile($image, $path, $user->avatar);

            $user->avatar = $file_data['filePath'];
            $user->update();
        } else {
            $user->avatar = null;
            $user->update();
        }
        
        return response()->json('success', 200);
        
    }

    public function logoutSession(Request $request, $sessionId)
    {
        try {
            $user = auth()->user();
            
            // Buscar el login asociado a esta sesión
            $userLogin = UserLogin::where('user_id', $user->id)
                                  ->where('session_id', $sessionId)
                                  ->first();

            if ($userLogin) {
                // Marcar como inactiva
                $userLogin->is_active = false;
                $userLogin->save();

                // Si es la sesión actual, cerrar sesión completamente
                if (session()->getId() === $sessionId) {
                    Auth::logout();
                    session()->flush();
                    
                    return response()->json([
                        'success' => true,
                        'redirect' => route('auth.login'),
                        'message' => 'Sesión cerrada exitosamente'
                    ], 200);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Sesión cerrada exitosamente'
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Sesión no encontrada'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cerrar sesión: ' . $e->getMessage()
            ], 500);
        }
    }

    public function logoutAllSessions(Request $request)
    {
        try {
            $user = auth()->user();
            $currentSessionId = session()->getId();

            // Obtener todos los logins activos del usuario excepto el actual
            $userLogins = UserLogin::where('user_id', $user->id)
                                   ->where('is_active', true)
                                   ->get();

            foreach ($userLogins as $login) {
                if ($login->session_id && $login->session_id !== $currentSessionId) {
                    // Marcar como inactiva (el middleware se encargará de cerrar la sesión)
                    $login->is_active = false;
                    $login->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Todas las sesiones han sido cerradas excepto la actual'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cerrar sesiones: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteAccount(Request $request)
    {
        if (!$request->password) {
            return redirect()->route('profile')->with([
                'delete_account_error' => 'Por favor, ingresa tu contraseña para eliminar la cuenta.'
            ]);
        }

        if (!Hash::check($request->password, auth()->user()->password)) {
            return redirect()->route('profile')->with([
                'delete_account_error' => 'La contraseña es incorrecta.'
            ]);
        }

        $user = User::find(auth()->user()->id);
        
        // Soft delete the user
        $user->delete();

        // Invalidate all sessions
        UserLogin::where('user_id', $user->id)
            ->update(['is_active' => false]);

        Auth::logout();
        session()->flush();

        return redirect()->route('auth.login')->with([
            'account_deleted_success' => true
        ]);
    }

}
