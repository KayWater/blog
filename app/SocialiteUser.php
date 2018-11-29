<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class SocialiteUser extends Authenticatable
{
    /**
     * database table
     * 
     * @var string
     */
    protected $table = 'socialites';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'socialite_id', 'driver', 'user_id', 'nickname', 'name', 'email', 
        'avatar', 'token', 'refresh_token', 'expires_in',
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'token', 'refresh_token',
    ];
}