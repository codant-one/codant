<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Carbon\Carbon;

use App\Models\PasswordReset;
use App\Models\User;

class PasswordResetController extends Controller
{
    public function forgot_password()
    {
       return view('auth.forgot-password');
    }

    public function email_confirmation(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user)
            return redirect()->route($request->route)->withErrors('Correo electrónico no registrado');

        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $request->email],
            ['token' => Str::random(60)]
        );
        
        $url = env('APP_URL').'/admin/reset-password?token='.$passwordReset['token'];
        
        $data = [
            'title' => 'Hemos recibido una solicitud para renovar la contraseña',
            'user' => $user->firstname . ' ' . $user->lastname,
            'text' => 'CODANT le informa, que hemos recibido su solicitud para renovar su contraseña. Por favor, confirme dicha solicitud haciendo clic en el enlace a continuación: ',
            'buttonLink' =>  $url ?? null,
            'buttonText' => 'Confirmar renovación de contraseña'
        ];

        $adminEmail = $user->email;
        
        $subject = 'Solicitud de renovación de contraseña';
        
        try {
            \Mail::send(
                'emails.auth.forgot_pass_confirmation'
                , $data
                , function ($message) use ($adminEmail, $subject) {
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $message->to($adminEmail)->subject($subject);
            });
            $success = true;
            $responseMail = 'Hemos enviado un email con los detalles para el restablecimiento de su contraseña';
        } catch (\Exception $e){
            $success = false;
            $responseMail = "Error al intentar enviar el email";//.$e->getMessage();
        }        

        return redirect()->route("auth.login")->with([
            "success" => $success,
            "register_success" => $responseMail, 
            "text" => "Revise la información e intente de nuevo"
        ]);

    }

    public function reset_password(Request $request)
    {
        $token = $request->token;

        return view('auth.reset-password', compact('token') );
        
    }

    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();

        if (!$passwordReset)
            return response()->json([
                "ERROR" => true,
                'ERROR_MESSAGE' => "Token no válido",
                "CODE" =>404
            ], 404);

        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                "ERROR" => true,
                'ERROR_MESSAGE' => "Token no válido", 
                "CODE" =>404
            ], 404);
        }

        $response["message_return"] = array("ERROR" => false, "ERROR_MESSAGE" => true, "CODE" => 200);
        $response["result"] = $passwordReset;

        return response()->json($response, 200);
    }

    public function change(Request $request)
    {
        if ($this->find($request->token)->status() != 200)
            return redirect()->back()->withErrors('Token no válido');

        $tokenValidated = json_decode($this->find($request->token)->content());
        $email = $tokenValidated->result->email;

        $user = User::where('email', $email)->first();

        if (!$user)
            return redirect()->back()->withErrors('Correo electrónico no registrado');

        $user->password = Hash::make($request->password);
        $user->token_2fa = null;
        $user->update();

        $response = 'La contraseña ha sido actualizada';

        return redirect()->route("auth.login")->with([
            "success" => true,
            "register_success" => $response
        ]);
    }
}
