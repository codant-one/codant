<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryType;

class CategoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryTypes = [
            ['name' => 'Skills', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Blog', 'created_at' => now(), 'updated_at' => now()],
        ];

        CategoryType::insert($categoryTypes);
    }
}
