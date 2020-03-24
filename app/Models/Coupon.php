<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use SoftDeletes;
    
    protected $hidden = [
        'deleted_at'
    ];

    protected $fillable =[
        'type', 'code','value' 
    ];
}
