<?php

namespace App\Http\Controllers\WEB\admin;

use App\FoodCategory;
use App\FoodType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FoodsController extends Controller
{
    public function __construct() {
        $this->middleware('admin-auth');
    }

    public function foodCreate() {
        $food_types = FoodType::all();
        $food_categories = FoodCategory::all();
        return view('admin.food.create', ['food_types'=>$food_types, 'food_categories' => $food_categories]);
    }

    //
    public function foodTypesCreate() {
        return view('admin.food_type.create');
    }

    public function foodTypesStore(Request $request) {
        $rules = [
            'name' => 'string|required|unique:App\FoodType,name',
            'description' => 'string|nullable'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        FoodType::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->back()->with(
            [
                'message'=>"Food Types $request->name Successfully Created",
                'variant'=>'success'
            ]
        );

    }
}
