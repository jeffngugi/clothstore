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

    
}
