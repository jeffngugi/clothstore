<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use SoftDeletes;
    protected $appends = [
        'category'
    ];

    protected $fillable = [
        'name','category_id',
    ];

    public function getCategoryAttribute(){
        return $this->category();
    }
    

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }
}
