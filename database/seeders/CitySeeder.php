<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

use App\Models\Province;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinces = Province::all()->toArray();

        $json = Storage::disk('local')->get('/json/cities.json');
        $cities = json_decode($json, true);

        $json_info = Storage::disk('local')->get('/json/provinces.json');
        $provinces_info = json_decode($json_info, true);

        foreach($provinces_info as $province) {

            $key = array_search($province['name'], array_column($provinces, 'name'));

            $arr_output = array_filter($cities, function($item) use ($province){
                // return everybody who is older than 10
                if($item['id_state'] == $province['id']){
                    return $item;
                }
            });

            foreach($arr_output as $city){
                City::query()->updateOrCreate([
                    'name' => $city['name'],
                    'province_id' => $provinces[$key]['id']
                ]);
            }
        }
    
    }
}
