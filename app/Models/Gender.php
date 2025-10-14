<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gender extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    /**** Relationship ****/
    public function state() {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    /**** Public methods ****/
    public static function forDropdown()
    {
        return DB::table('genders as g')
                 ->select(['g.id', 'g.name' ])
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
        return DB::table('genders as g')
            ->select(['g.id', 'g.name'])
            ->whereIn('g.state_id', $states)
            ->orderBy('name')
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
