<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Client;
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
            SkillSeeder::class,
            CategoryTypeSeeder::class,
            CategorySeeder::class,
            BlogSeeder::class,

            /* FACTORIES */
            ClientSeeder::class,
            AllySeeder::class,

            /* LANDING */
            ServiceSeeder::class
        ]);
    }
}
