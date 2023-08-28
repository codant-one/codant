<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Service;

class Request extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    /**** Relationship ****/
    public function user(){
        return $this->belongTo(User::class, 'user_id', 'id');
    }

    public function service(){
        return $this->belongTo(Request::class, 'service_id', 'id');
    }
   
}
