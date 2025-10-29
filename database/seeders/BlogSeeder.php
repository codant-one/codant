<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Faker\Factory as Faker;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $blogCategories = Category::whereHas('categoryType', function($query) {
            $query->where('name', 'Blog');
        })->get();

        $users = User::take(5)->get();

        if ($blogCategories->isEmpty() || $users->isEmpty()) {
            $this->command->info('No hay categorías de tipo Blog o usuarios disponibles. Ejecuta primero CategorySeeder y crea algunos usuarios.');
            return;
        }

        $blogs = [];

        for ($i = 0; $i < 30; $i++) {
            $titleEs = $faker->sentence(6);
            $titleEn = $faker->sentence(6);
            
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $titleEs)));

            $blogs[] = [
                'category_id' => $blogCategories->random()->id,
                'user_id' => $users->random()->id,
                'order_id' => null,
                'is_popular_blog' => $faker->boolean(30),
                'title_es' => $titleEs,
                'title_en' => $titleEn,
                'description_es' => $faker->paragraph(4),
                'description_en' => $faker->paragraph(4),
                'year' => $faker->numberBetween(2020, 2024),
                'image' => $faker->randomElement(['blog1.jpg', 'blog2.jpg', 'blog3.jpg', 'blog4.jpg', null]),
                'slug' => $slug,
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ];
        }

        Blog::insert($blogs);
    }
}