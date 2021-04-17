<?php

namespace App\Http\Controllers\WEB;

use App\FoodType;
use App\Http\Controllers\Controller;
use App\Rules\FoodTypeCheckRule;
use App\Rules\PaginationRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class FoodsController extends Controller
{
    //
    public function foodIndex(Request $request) {
        $rules = [
            'foodType' => [new FoodTypeCheckRule()],
            'pagination' => [new PaginationRule()],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return abort_page(404);
        }

        $food_types = FoodType::all();
        $foods_collection = DB::table('foods')
                            ->leftJoin('food_images', 'foods.id', '=', 'food_images.food_id')
                            ->leftJoin('food_types', 'foods.type_id', '=', 'food_types.id')
                            ->leftJoin('food_categories', 'foods.category_id', '=', 'food_categories.id')
                            ->select(
                                'foods.id as food_id', 'foods.category_id as food_category_id', 'foods.type_id as food_type_id',
                                'foods.name as food_name', 'foods.description as food_description', 'foods.price as food_price',
                                'foods.created_at as food_created_at', 'foods.updated_at as food_updated_at', 'foods.deleted_at as food_deleted_at',
                                'food_types.name as food_type_name', 'food_categories.name as food_category_name', 'food_categories.description as food_category_description',
                                'food_types.description as food_type_description', 'food_images.food_image_location as food_image_location'
                            );
        if (isset($request->foodType)) {
            $foods_collection->where('food_types.name', $request->foodType);
        }

        $paginate = 6;

        if (isset($request->pagination)) {
            $paginate = $request->pagination;
        }

        return view('menu.index', ['food_types'=>$food_types, 'foods'=>$foods_collection->paginate($paginate)]);
    }
}
