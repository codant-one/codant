<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Gender;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genders = [ 
            [
                'name' => 'Femenino',
                'code' => 'F',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Masculino',
                'code' => 'M',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Otros',
                'code' => 'O',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        Gender::insert($genders);
    }
}
