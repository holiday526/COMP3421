<?php

namespace App\Http\Controllers\WEB;

use App\FoodImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //
    public function indexIndex() {
        $feature_images = FoodImage::orderByRaw('RAND()')->take(3)->get();
        $feature_foods = DB::table('foods')
            ->leftJoin('food_images', 'foods.id', '=', 'food_images.food_id')
            ->leftJoin('food_types', 'foods.type_id', '=', 'food_types.id')
            ->leftJoin('food_categories', 'foods.category_id', '=', 'food_categories.id')
            ->select(
                'foods.id as food_id', 'foods.category_id as food_category_id', 'foods.type_id as food_type_id',
                'foods.name as food_name', 'foods.description as food_description', 'foods.price as food_price',
                'foods.created_at as food_created_at', 'foods.updated_at as food_updated_at', 'foods.deleted_at as food_deleted_at',
                'food_types.name as food_type_name', 'food_categories.name as food_category_name', 'food_categories.description as food_category_description',
                'food_types.description as food_type_description', 'food_images.food_image_location as food_image_location'
            )
            ->where('foods.deleted_at', '=', null)
            ->where('food_image_location', '!=', null)
            ->orderByRaw('RAND()')
            ->take(3)
            ->get();
        return view('index', ['feature_foods'=>$feature_foods]);
    }
}
