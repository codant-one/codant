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

        $superadmin1 = User::create([
            'firstname' => 'Steffani',
            'secondname' => '',
            'lastname' => 'Castro',
            'secondsurname' => '',
            'email' => 'steffani.castro@codant.one',
            'password' => Hash::make('admin'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);

        $superadmin1->assignRole('SuperAdmin');

        $superadmin2 = User::create([
            'firstname' => 'Diego',
            'secondname' => '',
            'lastname' => 'Bolivar',
            'secondsurname' => '',
            'email' => 'diego.bolivar@codant.one',
            'password' => Hash::make('admin'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);

        $superadmin2->assignRole('SuperAdmin');

        $superadmin3 = User::create([
            'firstname' => 'Freddy',
            'secondname' => '',
            'lastname' => 'Castro',
            'secondsurname' => '',
            'email' => 'freddy.castro@codant.one',
            'password' => Hash::make('admin'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);

        $superadmin3->assignRole('SuperAdmin');
        
    }
}
