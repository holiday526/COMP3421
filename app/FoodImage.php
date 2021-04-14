<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodImage extends Model
{
    //
    protected $fillable = [
        'food_id', 'food_image_location', 'index_photo'
    ];
}
