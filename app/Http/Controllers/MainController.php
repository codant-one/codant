<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Models\User;

use App\Mail\Contact;

use Validator;

class MainController extends Controller {
    
    public function index()
    {
        return view("index");
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->service = $request->service;
        $user->save();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'service' => $request->service,
            'description'=> $request->description,
        ];
        
        try {

            Mail::to(env('MAIL_FROM_ADDRESS'))->send(new Contact($data));

            if(Mail::failures() != 0) {
                return redirect()->route('index')->with('jsAlert', "Tu solicitud fue registrada de manera exitosa, nos comunicaremos contigo lo más pronto posible");
            } else {

                $message = "Tu email no fue enviado ocurrio un error inesperado"; 

                view("index", compact('message'));
            }
        } catch (\Exception $e) {
            return redirect()->route('index')->with('jsAlert', 'Tu solicitud se registro con exito! sin embargo hay un problema con el correo de confirmación'.$e);
        }
    }

}
