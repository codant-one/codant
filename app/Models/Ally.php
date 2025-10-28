<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Ally extends Model
{
    use HasFactory, HasRoles;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id',
        'fullname', 
        'email',
        'phone',
        'document',
        'year',
        'company',
        'url',
        'avatar',
        'logo',
    ];

    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
