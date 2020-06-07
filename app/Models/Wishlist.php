<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'product_id'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function products(){
        return $this->belongsTo('App\Models\Products');
    }

    protected $appends = [
        'product'
    ];
    public function getProductAttribute(){
        return Product::where('id', $this->product_id)->first();
        // return $this->product_id;
    }

    public function getProductsAttribute(){
        return Product::where('id', $this->product_id)->get();
        // return $this->product_id;
    }
}
