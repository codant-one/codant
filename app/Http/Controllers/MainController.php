<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\solicitud;
use Validator;
class MainController extends Controller
{
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

        $datosTexto = [
            'nombre' => $request->name,
            'correo' => $request->email,
            'servicio'=> $request->service,
            // Agrega más campos de texto según sea necesario
        ];
        
      // Envio de Correo
    try {

      Mail::to('dbolivarv90@gmail.com')->send(new solicitud($datosTexto));

       if(Mail::failures() != 0) {
            
            return redirect()->route('index')->with('jsAlert', "Tu solicitud fue registrada de manera exitosa, nos comunicaremos contigo lo más pronto posible");
        }else {
            $message = "Tu email no fue enviado ocurrio un error inesperado"; 

            view("index", compact('message'));
        }
    }
        catch (\Exception $e)
            {return redirect()->route('index')->with('jsAlert', 'tu solicitud se registro con exito! sin embargo hay un problema con el correo de confirmación' );}

    }

}
