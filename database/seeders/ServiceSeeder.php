<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {      
        $services = [
            [
                'label' => 'Diseño UI/UX',
                'es' => 'Diseño UI/UX',
                'en' => 'UI/UX Design',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'label' => 'Desarrollo de APIS',
                'es' => "Desarrollo de API's",
                'en' => "API's Development",
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'label' => 'Desarrollo web',
                'es' => 'Desarrollo web',
                'en' => 'Web development',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'label' => 'Backoffice',
                'es' => 'Backoffice',
                'en' => 'Backoffice',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'label' => 'Aplicaciones móviles',
                'es' => 'Aplicaciones móviles',
                'en' => 'Mobile apps',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'label' => 'Optimización del sitio web',
                'es' => 'Optimización del sitio web',
                'en' => 'Website Optimization',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'label' => 'Productos digitales',
                'es' => 'Productos digitales',
                'en' => 'Digital products',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'label' => 'Consultoría',
                'es' => 'Consultoría',
                'en' => 'Consultancy',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        Service::insert($services);
    }
}
