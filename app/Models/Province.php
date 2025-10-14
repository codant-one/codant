<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Province extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    /**** Relationship ****/
    public function country(){
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function state(){
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    /**** Public methods ****/
    public static function forDropdown()
    {
        return DB::table('provinces as p')
            ->select(['p.id', 'p.name' ])
            ->orderBy('p.name')
            ->get()->pluck('name','id');
    }

    /**
     * forDropdownByState: Get registers by states
     * 
     * @param Array  states
     */
    public static function forDropdownByStates($states)
    {
        return DB::table('provinces as p')
            ->select(['p.id', 'p.name'])
            ->whereIn('p.state_id', $states)
            ->orderBy('p.name')
            ->get()->pluck('name','id');
        
    }

    /**** Attributes ****/
    public function getStateLabelAttribute() {
        switch ($this->state_id) {
            case 1://inactivo
                $class = 'badge-status-disabled';
                $name = 'Deshabilitado';
            break;
            case 2://Activo
                $class = 'badge-status-enabled';
                $name = 'Habilitado';
            break;
        }

        return '<span class="text-status-request ' . $class . '">'. $name . '</span>';
    }
}
