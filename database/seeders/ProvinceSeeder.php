<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

use App\Models\Province;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('/json/countries.json');
        $countries = json_decode($json, true);

        $json = Storage::disk('local')->get('/json/provinces.json');
        $provinces = json_decode($json, true);

        $json_info = Storage::disk('local')->get('/json/countries_info.json');
        $countries_info = json_decode($json_info, true);

        foreach($countries as $country){

            $key = array_search($country['name'], array_column($countries_info, 'nicename'));

            $arr_output = array_filter($provinces, function($item) use ($country){
                // return everybody who is older than 10
                if($item['id_country'] == $country['id']){
                    return $item;
                }
            });

            foreach($arr_output as $province){
                Province::query()->updateOrCreate([
                    'name' => $province['name'],
                    'country_id' => $countries_info[$key]['id']
                ]);
            }
        }
    
    }
}
