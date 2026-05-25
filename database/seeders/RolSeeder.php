<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Role; 

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['SuperAdmin', 'Administrador'];

        foreach($roles as $role){
            Role::create(['name' => $role]);
        }

    }
}
