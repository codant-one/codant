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
        //dd($request->all());
        $requestUser = new RequestUser();
        $requestUser->name = $request->name;
        $requestUser->email = $request->email;
        $requestUser->service_id = $request->service_id;
        $requestUser->description = $request->description;
        $requestUser->save();

        $service = Service::find($request->service_id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'service' => $service->label,
            'description'=> $request->description,
        ];
        
        try {

            Mail::to(explode(',', env('MAIL_TO_ADDRESS')))->send(new Contact($data));

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
