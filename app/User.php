<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username','email', 'password','api_token'
    ];


    /**
     * 当用户没有头像的时候，返回gravatar
     * @param $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        if (empty(trim($value))) {
            return Gravatar::src($this->email);
        }
        return $value;
    }


    public function order()
    {
        return $this->hasMany('App\Order', 'user_id', 'id');
    }

    public function host()
    {
        return $this->hasMany('App\Host', 'user_id', 'id');
    }

    public function workOrder()
    {
        return $this->hasMany('App\Ticket', 'user_id', 'id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
