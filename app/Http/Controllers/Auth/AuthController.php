<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Country;
use App\Models\User;
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

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            $user->online = Carbon::now();
            $user->save();

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

        return view('auth.login');
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
            $token_2fa = explode("-", $request->token_2fa)[0].explode("-", $request->token_2fa)[1];

            if ($google2fa->verifyKey($user->token_2fa, $token_2fa)) {
                session()->put('2fa', '1');
                session()->put('login', 'admin');

                if($request->panel) {
                    $user->is_2fa =  ($user->is_2fa === 0) ? 1 : 0;
                    $user->update();

                    return redirect()->route('profile')->with([
                        'feedback' => [
                            'type' => 'toastr',
                            'action' => 'success',
                            'message' => 'Datos actualizados exitosamente'
                        ]
                    ]);
                }

                return redirect()->route('admin.dashboard.index');
            }

            return redirect()->route($request->route)->with([
                'register_error' => 'Código de verificación incorrecto',
                'text' => 'Verifique nuevamente'
            ]);
        } catch (\Exception $e) {
            return redirect()->route($request->route)->withErrors(['error' => $e->getMessage()]);
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

        return view('auth.generate-2fa', compact('user', 'qr', 'token'));
    }

    public function double_factor_auth()
    {
        $user = auth()->user();
        $token = $user->token_2fa;

        if (session()->has('2fa'))
            return redirect()->route('admin.dashboard.index');

        return view('auth.2fa', compact('user'));
    }

    public function profile(){

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

        return view('auth.profile',
            compact(
                'qr',
                'token',
                'profileCompletenessPercentage',
                'countries',
                'countriesActives',
                'countriesPhoneCodes',
                'countriesDetails',
                'gendersActives'
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

        return redirect()->route("profileStore")->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Datos actualizados exitosamente'
            ]
        ]);
        
    }

    public function updatePassword(Request $request){

        $validate = Validator::make($request->all(),
            [ 'current_password' => 'required|current_password' ],
            [ 'current_password.current_password' => 'La contraseña actual no coincide' ]
        ); 

        if($validate->fails()){
            return redirect()->route("profileStore")->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => $validate->errors()->first()
                ]
            ]);
        } 

        $user = User::find(auth()->user()->id);
        $user->password = Hash::make($request->new_password);
        $user->update();

        return redirect()->route("profileStore")->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Datos actualizados exitosamente'
            ]
        ]);
        
    }

}
