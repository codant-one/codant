<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = ['Deshabilitado', 'Habilitado', 'Pendiente'];

        foreach($states as $state){
            State::create(['name' => $state]);
        }

    }
}
