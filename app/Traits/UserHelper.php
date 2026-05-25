<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\UserDetails;
use App\Models\Address;

/**
 * Trait for models with stores
 */
trait UserHelper
{
    /**** Public methods ****/
    public static function forDropdown($select = true){

        $users = self::all()->pluck('name', 'id')->toArray();

        if($select)
            $users = array(0 => 'Seleccione') + $users;

    	return $users;
    }

    public function createOrUpdateAddress(Request $request)
    {
        $address = $this->address ? Address::find($this->address->id) : new Address;
        $address->user_id = $request->input('user_id') ?? $this->id;
        $address->city_id = $request->input('city_id');
        $address->address = $request->input('details-address');
        $address->lat = $request->input('mapLat');
        $address->lon = $request->input('mapLon');
        $address->map_description = $request->input('mapDesc');
        $address->image = $request->input('mapImage');
        $address->postal_code = $request->input('postal_code');

        $this->address ? $address->update() : $address->save();

        return $address;
    }

    public function createOrUpdateUserDetails(Request $request, $address)
    {
        $userDetails = new UserDetails;
        $userDetails->user_id = $request->input('user_id') ?? $this->id;
        $userDetails->gender_id = $request->input('gender_id');
        $userDetails->address_id = $address->id ?? null;
        $userDetails->phone = $request->input('phone');
        $userDetails->document = $request->input('document');
        $userDetails->birthday = $request->input('birthday');

        $this->userDetail ? $userDetails->update() : $userDetails->save();
    }

}
