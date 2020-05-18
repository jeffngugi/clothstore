<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use SoftDeletes;
   
    protected $hidden = [
        'deleted_at'
    ];

    protected $fillable = [
        'name','category_id',
    ];

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }


    public function products(){
        return $this->hasMany('App\Models\Product');
    }

}
