<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name','description', 'price', 'specification','status','color','quantity', 'slug', 'discount','user_id', 'type_id','category_id',
    ];

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function reviews(){
        return $this->hasMany('App\Models\Review');
    }

    public function images(){
        return $this->hasMany('App\Models\Image');
    }

    public function type(){
        return $this->belongsTo('App\Models\Type');
    }


}
