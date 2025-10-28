<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Ally;
use Faker\Factory as Faker;

class AllySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $commonCountries = [47, 231, 159, 200, 1, 2, 3]; // Colombia, Venezuela, México, Perú, etc.

        $allies = [];

        for ($i = 0; $i < 50; $i++) {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            $fullName = $firstName . ' ' . $lastName;
            $company = $faker->company;
            
            $email = strtolower($firstName . '.' . $lastName . '@' . str_replace(' ', '', $company) . '.com');
            $email = str_replace([' ', ',', "'"], '', $email); 

            $allies[] = [
                'country_id' => $faker->randomElement($commonCountries),
                'fullname' => $fullName,
                'email' => $email,
                'phone' => $faker->phoneNumber,
                'document' => $faker->randomNumber(9, true),
                'year' => $faker->numberBetween(1990, 2023),
                'company' => $company,
                'url' => 'https://' . str_replace(' ', '', $company) . '.com',
                'avatar' => $faker->optional(0.7)->passthrough('avatars/' . $faker->word . '.jpg'),
                'logo' => $faker->optional(0.5)->passthrough('logos/' . $faker->word . '.png'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Ally::insert($allies);
    }
}
