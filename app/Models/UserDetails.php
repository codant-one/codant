<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    protected $guarded = [];
    
    /**** Relationship ****/
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function gender() {
        return $this->belongsTo(Gender::class, 'gender_id', 'id');
    }

    public function address() {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }

}
