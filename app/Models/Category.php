<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name'
    ];

    public function products(){
        return $this->hasMany('App\Models\Product');
    }

    public function subcategories(){
        return $this->hasMany('App\Models\SubCategory');
    }

}
