<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'product_id'
    ];

    public function product(){
        return  $this->belongsTo('App\Models\Product');
    }
}
