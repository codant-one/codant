<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Country extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    /**** Relationship ****/
    public function state() {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function provinces() {
        return $this->hasMany(Province::class, 'country_id', 'id');
    }

    /**** Public methods ****/
    public static function forDropdown()
    {
        return DB::table('countries as c')
            ->select(['c.id', 'c.name'])
            ->orderBy('name')
            ->get()->pluck('name','id');
    }

    public static function forDropdownByID($id)
    {
        return DB::table('countries as c')
            ->select(['c.id', 'c.name'])
            ->where('id', $id)
            ->orderBy('name')
            ->get()->pluck('name','id');
    }
    

    /**
     * forDropdownByState: Get registers by states
     * 
     * @param Array  states
     */
    public static function forDropdownByStates($states)
    {
        return DB::table('countries as c')
            ->select(['c.id', 'c.name'])
            ->whereIn('c.state_id', $states)
            ->orderBy('name')
            ->get()->pluck('name','id');
        
    }

    public static function phonePrefix()
    {
        return DB::table('countries as c')
            ->select(['c.id', 'c.phonecode'])
            ->orderBy('id')
            ->get()->pluck('phonecode','id');
        
    }

    /**** Attributes ****/
    public function getStateLabelAttribute()
    {
        switch ($this->state_id) {
            case 1:
                $class = 'warning';
                break;
            case 2:
                $class = 'primary';
                break;
            case 3:
                $class = 'info';
                break;
            case 4:
                $class = 'success';
                break;
            case 5:
                $class = 'danger';
                break;
        }

        return '<div class="badge badge-light-' . $class . ' fs-8 fw-bolder">'. $this->state['name'] . '</div>';
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function allies()
    {
        return $this->hasMany(Ally::class);
    }

}
