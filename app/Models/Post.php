<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Post extends Model
{
    /**
     * fill into table posts
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'content', 'img', 'user_id', 'status',
    ];

    public function user() {
        return $this->belongsTo('User');
    }
}
