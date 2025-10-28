<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = [
            ['name_es' => 'HTML5', 'name_en' => 'HTML5'],
            ['name_es' => 'TypeScript', 'name_en' => 'TypeScript'],
            ['name_es' => 'Vue.js', 'name_en' => 'Vue.js'],
            ['name_es' => 'Angular', 'name_en' => 'Angular'],
            ['name_es' => 'Tailwind CSS', 'name_en' => 'Tailwind CSS'],
            ['name_es' => 'Bootstrap', 'name_en' => 'Bootstrap'],
            ['name_es' => 'PHP', 'name_en' => 'PHP'],
            ['name_es' => 'Laravel', 'name_en' => 'Laravel'],
            ['name_es' => 'Node.js', 'name_en' => 'Node.js'],
            ['name_es' => 'MySQL', 'name_en' => 'MySQL'],
            ['name_es' => 'SQLite', 'name_en' => 'SQLite'],
            ['name_es' => 'Redis', 'name_en' => 'Redis'],
        ];

        Skill::insert($skills);
    }
}
