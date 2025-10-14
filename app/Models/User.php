<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

use App\Models\UserDetails;

use App\Traits\UserHelper;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles, UserHelper;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 
        'secondname', 
        'lastname', 
        'secondsurname', 
        'email', 
        'phone', 
        'email_verified_at', 
        'password', 
        'full_profile'
    ];

    protected $guarded = [];

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    static public function boot()
    {
        parent::boot();
    }

    // protected $appends = ['role_name'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**** Relationship ****/
    public function userDetail(){
        return $this->hasOne(UserDetails::class, 'user_id', 'id');
    }
}
