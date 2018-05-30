<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Role;
use App\Models\Comment;
use App\Models\Rate;
use App\Models\Order;
use App\Models\Post;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role() {
        return $this->belongsTo('Role');
    }

    public function comments() {
        return $this->hasMany('Comment');
    }

    public function rates() {
        return $this->hasMany('Rate');
    }

    public function orders() {
        return $this->hasMany('Order');
    }

    public function posts() {
        return $this->hasMany('Post');
    }
}
