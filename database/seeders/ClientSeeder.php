<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = [
            [
                'country_id' => 47,
                'fullname' => 'Steffani Castro',
                'email' => 'steffani@email.com',
                'phone' => '+57 300 123 4567',
                'document' => '123456789',
                'company' => 'Codant Solutions SA',
                'url' => 'https://codant-solutions.com',
                'avatar' => 'avatars/steffani.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'country_id' => 231,
                'fullname' => 'Klengery Rodriguez',
                'email' => 'klengery@empresa.com',
                'phone' => '+58 310 987 6543',
                'document' => '987654321',
                'company' => 'Innovation Labs',
                'url' => 'https://innovation-labs.co',
                'avatar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'country_id' => 159,
                'fullname' => 'Gabriel Gomez',
                'email' => 'gabriel@negocio.com',
                'phone' => '+52 55 1234 5678',
                'document' => 'MX123456789',
                'company' => 'Global Trading',
                'url' => 'https://global-trading.mx',
                'avatar' => 'avatars/carlos-hernandez.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'country_id' => 200,
                'fullname' => 'Diego Bolivar',
                'email' => 'diego@negocio.com',
                'phone' => '+52 55 1234 4708',
                'document' => 'MX6656558898',
                'company' => 'Global Trading',
                'url' => 'https://global-trading.mx',
                'avatar' => 'avatars/carlos-hernandez.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        Client::insert($clients);
    }
}
