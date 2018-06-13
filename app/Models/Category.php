<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{
    /**
     * fill into table Categories
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'parent_id', 'status'
    ];

    public function products()
    {
        return $this->hasMany('Product');
    }

    public function parent()
    {
        $parent = self::find($this->parent_id);
        if (!$parent) {
            return;
        }

        return $parent->name;
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
