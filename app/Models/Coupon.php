<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use SoftDeletes;
    
    protected $fillable =[
        'name', 'percent_discount','type','code','percent','value'
    ];
}
