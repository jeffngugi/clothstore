<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];
    public function products(){
        return $this->hasMany('App\Models\Product');
    }
}
