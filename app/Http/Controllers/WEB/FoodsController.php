<?php

namespace App\Http\Controllers\WEB;

use App\FoodType;
use App\Http\Controllers\Controller;
use App\Rules\FoodTypeCheckRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class FoodsController extends Controller
{
    //
    public function foodIndex(Request $request) {
        $rules = [
            'foodType' => [new FoodTypeCheckRule()]
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return abort_page(404);
        }

        $food_types = FoodType::all();
        $foods_collection = DB::table('foods');
        if (isset($request->foodType)) {
            $foods_collection->leftJoin('food_types', 'foods.type_id', '=', 'food_types.id')
                ->where('food_types.name', $request->foodType);
        }
//        dd($foods_collection->get());
        return view('menu.index', ['food_types'=>$food_types]);
    }
}
