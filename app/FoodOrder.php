<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodOrder extends Model
{
    //
    protected $fillable = [
        'order_id', 'user_uid', 'food_id', 'quantity', 'processed'
    ];
}
