<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodType extends Model
{
    //
    protected $table = 'food_types';

    protected $fillable = [
        'name', 'description'
    ];
}
