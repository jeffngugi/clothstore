<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use SoftDeletes;
    protected $fillable = ['cart_id','product_id','quantity'];

    public function cart(){
        return  $this->belongsTo('App\Models\Cart');
    }
}
