<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'country', 'enterprise', 'address', 'job', 'photo', 'gender', 'phone', 'address', 'lname', 'fname', 'password', 'email', 'enterprise_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function favorites()
    {
        return $this->hasMany('App\Favorite');
    }

    public function enterprise()
    {
        return $this->belongsTo('App\Enterprise');
    }

    public function getProductsCountAttribute()
    {
        return $this->products->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites()->count();
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
