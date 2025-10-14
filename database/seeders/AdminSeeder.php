<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::create([
            'firstname' => 'Super',
            'secondname' => '',
            'lastname' => 'Administrador',
            'secondsurname' => '',
            'email' => 'admin@codant.one',
            'password' => Hash::make('admin'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);

        $superadmin->assignRole('SuperAdmin');        
    }
}
