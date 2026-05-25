<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UserHelper;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, UserHelper, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
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

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    static public function boot()
    {
        parent::boot();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
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
    
    public function address() {
        return $this->hasOne(Address::class, 'user_id', 'id');
    }

    public function logins(){
        return $this->hasMany(UserLogin::class, 'user_id', 'id');
    }
}
