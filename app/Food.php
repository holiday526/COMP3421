<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    //
    use SoftDeletes;

    protected $table = 'foods';

    protected $fillable = [
        'category_id', 'type_id', 'name', 'description', 'price',
        'meal_set',
    ];
}
