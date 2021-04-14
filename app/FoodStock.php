<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodStock extends Model
{
    //
    protected $fillable = [
        'food_id', 'quantity'
    ];
}
