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

    protected $hidden = [
        'deleted_at'
    ];

    protected $appends = [
        'url'
    ];

    public function getUrlAttribute(){
        return asset('/storage/cloths/' . $this->name);
    }

    public function product(){
        return  $this->belongsTo('App\Models\Product');
    }
}
