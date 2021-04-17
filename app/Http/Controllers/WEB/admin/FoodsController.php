<?php

namespace App\Http\Controllers\WEB\admin;

use App\FoodCategory;
use App\FoodType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Food;

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

    public function foodStore(Request $request) {
        $rules = [
            'name' => 'required|string|Unique:App\Food,name',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1',
            'type_id' => 'required|exists:App\FoodType,id',
            'category_id' => 'nullable|exists:App\FoodCategory,id'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        Food::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'type_id' => $request->type_id,
            'category_id' => empty($request->category_id) ? null : $request->category_id
        ]);

        return redirect()->back()->with(
            [
                'message'=>"Food $request->name Successfully Created",
                'variant'=>'success'
            ]
        );
    }

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

    public function foodCategoryCreate() {
        return view('admin.food_category.create');
    }

    public function foodCategoryStore(Request $request) {
        $rules = [
            'name' => 'string|required|unique:App\FoodCategory,name',
            'description' => 'string|nullable'
        ];

        $validator = Validator::make($request->all(), $rules, ['unique' => "The category name $request->name is already taken"]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        FoodCategory::create([
            'name' => $request->name,
            'description' => empty($request->description) ? '' : $request->description
        ]);

        return redirect()->back()->with(
            [
                'message'=>"Food Category $request->name Successfully Created",
                'variant'=>'success'
            ]
        );
    }
}
