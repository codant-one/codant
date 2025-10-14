<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolSeeder::class,
            PermissionSeeder::class,
            AdminSeeder::class,

            StateSeeder::class,
            GenderSeeder::class,
            
            CountrySeeder::class,
            ProvinceSeeder::class,
            CitySeeder::class,

            /* LANDING */
            ServiceSeeder::class
        ]);
    }
}
