<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Request;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    /**** Relationship ****/
    public function requests(){
        return $this->hasMany(Request::class, 'service_id', 'id');
    }
   
}
