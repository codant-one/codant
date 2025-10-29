<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\CategoryType;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skillsType = CategoryType::where('name', 'Skills')->first();
        $blogType = CategoryType::where('name', 'Blog')->first();

        $categories = [
            [
                'category_type_id' => $skillsType->id,
                'name_es' => 'Frontend',
                'name_en' => 'Frontend'
            ],
            [
                'category_type_id' => $skillsType->id,
                'name_es' => 'Backend', 
                'name_en' => 'Backend'
            ],
            [
                'category_type_id' => $skillsType->id,
                'name_es' => 'DevOps',
                'name_en' => 'DevOps'
            ],
            [
                'category_type_id' => $skillsType->id,
                'name_es' => 'Base de datos',
                'name_en' => 'Database'
            ],
            [
                'category_type_id' => $skillsType->id,
                'name_es' => 'Mobile',
                'name_en' => 'Mobile'
            ],
            [
                'category_type_id' => $blogType->id,
                'name_es' => 'Tutoriales',
                'name_en' => 'Tutorials'
            ],
            [
                'category_type_id' => $blogType->id,
                'name_es' => 'Noticias',
                'name_en' => 'News'
            ],
            [
                'category_type_id' => $blogType->id,
                'name_es' => 'Guías',
                'name_en' => 'Guides'
            ],
            [
                'category_type_id' => $blogType->id,
                'name_es' => 'Proyectos',
                'name_en' => 'Projects'
            ],
        ];

        Category::insert($categories);
    }
}
