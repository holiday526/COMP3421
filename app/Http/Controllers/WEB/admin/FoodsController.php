<?php

namespace App\Http\Controllers\WEB\admin;

use App\FoodCategory;
use App\FoodImage;
use App\FoodType;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Food;
use Illuminate\Validation\ValidationData;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class FoodsController extends Controller
{
    public function __construct() {
        $this->middleware('admin-auth');
    }

    public function foodListIndex(Request $request) {
        $rules = [
            'food_id' => 'exists:App\Food,id'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response(['message'=>$validator->errors()->getMessages()], 400);
        }

        $foods = DB::table('foods')
            ->leftJoin('food_types', 'foods.type_id', '=', 'food_types.id')
            ->leftJoin('food_categories', 'foods.category_id', '=', 'food_categories.id')
            ->select(
                'foods.id as food_id', 'food_categories.name as food_category_name', 'food_types.name as food_type_name',
                'foods.name as food_name', 'foods.description as food_description', 'foods.price as food_price',
                'foods.updated_at as food_updated_at', 'foods.deleted_at as food_delete_at',
                'foods.type_id as food_type_id', 'foods.category_id as food_category_id'
            );
        if (!empty($request->food_id)) {
            $foods = $foods->where('foods.id', $request->food_id);
        }
        $foods = $foods->orderBy('type_id');
        return response(['foods'=>$foods->get()], 200);
    }

    public function foodIndex() {
        return view('admin.food.index');
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
            'category_id' => 'nullable|exists:App\FoodCategory,id',
            'food_image' => 'image|required|max:10000'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $imagePath = request('food_image')->store("uploads/food", 'public');
        $image = Image::make(public_path("storage/{$imagePath}"))->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save(public_path("storage/{$imagePath}"), 100);

        $image->save();

        $food = Food::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'type_id' => $request->type_id,
            'category_id' => empty($request->category_id) ? null : $request->category_id
        ]);

        FoodImage::create([
            'food_id' => $food->id,
            'food_image_location' => "/storage/".$imagePath,
            'index_photo' => true
        ]);

        return redirect()->back()->with(
            [
                'message'=>"Food $request->name Successfully Created",
                'variant'=>'success'
            ]
        );
    }

    public function foodUpdate(Request $request) {

        $rules = [
            'food_id' => 'required|exists:App\Food,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'type_id' => 'required|exists:App\FoodType,id',
            'category_id' => 'exists:App\FoodCategory,id',
            'food_image' => 'image|max:10000'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        Food::where('id', $request->food_id)
            ->update([
                'category_id'=> isset($request->category_id) ? $request->category_id : null,
                'type_id' => $request->type_id,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price
            ]);

        if (!empty($request->food_image)) {
            $imagePath = request('food_image')->store("uploads/food", 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->save(public_path("storage/{$imagePath}"), 100);

            $image->save();

            FoodImage::updateOrCreate(
                    ['food_id' => $request->food_id],
                    ['food_image_location'=>"/storage/".$imagePath, 'index_photo'=>true]
                );
        }

        return redirect()->back()->with(
            [
                'message'=>"Food $request->name Successfully Updated",
                'variant'=>'success'
            ]
        );
    }

    public function foodEdit($food_id) {
        $rules = [
            'food_id' => 'required|exists:App\Food,id'
        ];

        $input = [
            'food_id' => $food_id
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return view('error.error', ['url'=>'/admin/food/edit', 'button_message'=>'Back to food edit page', 'code'=>404]);
        }

        $food_types = FoodType::all();
        $food_categories = FoodCategory::all();

        return view('admin.food.edit', ['food_id'=>$food_id, 'food_types'=>$food_types, 'food_categories'=>$food_categories]);
    }

    public function foodDelete(Request $request) {

        $rules = [
            'food_id' => 'required|exists:App\Food,id'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response(['message'=>$validator->errors()->getMessages()], 400);
        }

        Food::find($request->food_id)->delete();

        return response(['status'=>'success'], 204);
    }

    public function foodRestore(Request $request) {
        $rules = [
            'food_id' => 'required|exists:App\Food,id'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response(['message'=>$validator->errors()->getMessages()], 400);
        }

        Food::withTrashed()->find($request->food_id)->restore();

        return response(['status'=>'success'], 202);
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

    public function foodTypeIndex() {
        return view('admin.food_type.index');
    }

    public function foodTypeShow($food_type_id) {
        $rules = [
            'food_type_id' => 'required|exists:App\FoodType,id'
        ];

        $validator = Validator::make(['food_type_id'=>$food_type_id], $rules);

        if ($validator->fails()) {
            return response(['message'=>$validator->errors()->getMessages()], 403);
        }

        $burger_type_id = FoodType::where('name', 'Burger')->first()->id;

        if ($food_type_id === $burger_type_id) {
            return response(['message'=>'cannot edit burger type'], 403);
        }

        return response(['food_type'=>FoodType::find($food_type_id)], 200);
    }

    public function foodTypeEdit($food_type_id) {
        return view('admin.food_type.edit', ['food_type_id'=>$food_type_id]);
    }

    public function foodTypeListIndex() {
        return response(['food_types'=>FoodType::all()], 200);
    }

    public function foodTypeUpdate(Request $request) {
        $rules = [
            'id' => 'required|exists:App\FoodType,id',
            'name' => 'required|string',
            'description' => 'string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        FoodType::where('id', $request->id)->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->back()->with(
            [
                'message'=>"Food type $request->name Successfully Updated",
                'variant'=>'success'
            ]
        );

    }

    public function foodTypeDelete(Request $request) {
        $rules = [
            'id' => 'required|exists:App\FoodType,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if ($request->id === FoodType::where('name', 'Burger')->first()->id) {
            return redirect()->back()->withErrors($validator);
        }

        FoodType::where('id', $request->id)->delete();

        return redirect()->back()->with(
            [
                'message'=>"Food type $request->name Successfully deleted",
                'variant'=>'success'
            ]
        );

    }

    public function foodCategoryList() {
        return response(['food_categories'=> FoodCategory::all()], 200);
    }

    public function foodCategoryIndex() {
        return view('admin.food_category.index');
    }

    public function foodCategoryShow($food_category_id) {
        $rules = [
            'food_category_id' => 'required|exists:App\FoodCategory,id'
        ];

        $validator = Validator::make(['food_category_id'=>$food_category_id], $rules);

        if($validator->fails()) {
            return response(['message'=>$validator->errors()->getMessages()],400);
        }

        return response(['food_category'=>FoodCategory::find($food_category_id)], 200);
    }

    public function foodCategoryEdit($food_category_id) {
//        $rules = [
//            'food_category_id' => 'required|exists:App\FoodCategory,id'
//        ];
//
//        $validator = Validator::make(['food_category_id'=>$food_category_id], $rules);
//
//        if ($validator->fails()) {
//            return response();
//        }

        return view('admin.food_category.edit', ['food_category_id'=>$food_category_id]);
    }

    public function foodCategoryUpdate(Request $request) {
        $rules = [
            'id' => 'required|exists:App\FoodCategory,id',
            'name' => 'required|string',
            'description' => 'string'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        FoodCategory::where('id', $request->id)->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->back()->with(
            [
                'message'=>"Food category $request->name Successfully Updated",
                'variant'=>'success'
            ]
        );
    }

    public function foodCategoryDelete(Request $request) {
        $rules = [
            'food_category_id' => 'required|exists:App\FoodCategory,id'
        ];

        $validator = Validator::make(['food_category_id'=>$request->food_category_id], $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        FoodCategory::where('id', $request->food_category_id)->delete();

        return redirect()->back()->with(
            [
                'message'=>"Food category ID: $request->food_category_id Successfully deleted",
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
