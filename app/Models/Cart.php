<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use SoftDeletes;
    //
    protected $fillable = ['user_id'];

    public function cartItems(){
        return $this->hasMany('App\Models\CartItem');
    }

    
}
