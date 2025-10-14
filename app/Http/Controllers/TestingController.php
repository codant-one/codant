<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\User;

class TestingController extends Controller
{
    public function emails() {

        $user = User::find(1);

        $url = env('APP_DOMAIN_ADMIN').'/reset-password?token='.Str::random(60).'&user='.$user->email;

        $info = [
            'subject' => 'Password change request',
            'buttonLink' =>  $url ?? null,
            'email' => 'emails.auth.client_created'
        ]; 
        
        $buttonLink = $url;
        $title = 'Cuenta creada satisfactoriamente!!!';
        $text =  'Beetcg le informa, que hemos recibido su solicitud para renovar su contraseña. Por favor, confirma dicha solicitud haciendo clic en el enlace a continuación: ';
        $text2 =  'Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                                                Pellentesque feugiat porttitor felis vel iaculis. 
                                                                            Suspendisse et ipsum tristique, accumsan ante aliquam,
                                                                             vulputate ipsum.';
        $buttonText = 'Confirmar renovación de contraseña';
        $user = $user->firstname . ' ' . $user->lastname;
        $LinkText = 'https://google.com';
        $Link = 'asads';

        // $data = [
        //     'title' => $info['title'] ?? null,
        //     'user' => $user->firstname . ' ' . $user->lastname,
        //     'email' => $user->email,
        //     'password' => Str::random(10),
        //     'text' => $info['text'] ?? null,
        //     'buttonLink' =>  $info['buttonLink'] ?? null,
        //     'buttonText' =>  $info['buttonText'] ?? null,
        //     'type' => 1
        // ];

        return view('emails.users.notifications', 
            compact(
                'buttonLink',
                'buttonText',
                'title',
                'text',
                'user',
                'text2'
            )
        );
    }

}
