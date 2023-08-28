<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use App\Models\Service;
use App\Models\Request as RequestUser;

use App\Mail\Contact;

use Validator;

class MainController extends Controller {
    
    public function index()
    {
        $services = Service::all();

        return view("index", compact('services'));
    }

    public function store(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if(!$user) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
        }

        $description = $request->description;
        $service = Service::find($request->service_id);

        $request = new RequestUser();
        $request->user_id = $user->id;
        $request->service_id = $service->id;
        $request->description = $description;
        $request->save();

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'service' => $service->label,
            'description'=> $description,
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
            return redirect()->route('index')->with('jsAlert', 'Tu solicitud se registro con exito! sin embargo hay un problema con el correo de confirmación'. $e);
        }
    }

}
