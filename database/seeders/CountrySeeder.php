<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;

use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json_info = Storage::disk('local')->get('/json/countries_info.json');
        $countries_info = json_decode($json_info, true);

        if (!file_exists(storage_path('app/public/flags'))) {
            mkdir(storage_path('app/public/flags'), 0755,true);
        } //create a folder

        $file = new Filesystem;
        $file->cleanDirectory('storage/app/public/flags');

        foreach($countries_info as $country){

            Country::query()->updateOrCreate([
                'id' => $country['id'],
                'max_month_amount' => $country['max_month_amount'],
                'iso' => $country['iso'],
                'name' => $country['name'],
                'nicename' => $country['nicename'],
                'iso3' => $country['iso3'],
                'numcode' => $country['numcode'],
                'phonecode' => $country['phonecode'],
                'phone_digits' => $country['phone_digits'],
                'flag' => ($country['flag'] === 'null') ? null : $country['flag']
            ]);

            if($country['flag'] !== 'null')
                copy(public_path('images/'.$country['flag']), storage_path('app/public/').$country['flag']);
        }
    }
}
