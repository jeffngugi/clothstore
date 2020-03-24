<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'product_id', 'text','stars' 
    ];


}
