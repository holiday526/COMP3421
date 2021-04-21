<?php

namespace App\Http\Controllers\WEB;

use App\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Food;
use Illuminate\Support\Facades\DB;

class CartsController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth');
    }

    public function cartIndex() {
        $user = Auth::user();

        $cart = DB::table('carts')
            ->leftJoin('foods', 'carts.food_id', '=', 'foods.id')
            ->leftJoin('food_types', 'foods.type_id', '=', 'food_types.id')
            ->leftJoin('food_categories', 'foods.category_id', '=', 'food_categories.id')
            ->where('carts.user_uid', $user->uid)
            ->select(
                'carts.food_id as cart_food_id', 'carts.quantity as cart_quantity', 'carts.updated_at as cart_updated_at',
                'foods.category_id as food_category_id', 'foods.type_id as food_type_id', 'foods.name as food_name',
                'foods.price as food_price', 'food_categories.name as food_category_name', 'food_types.name as food_type_name'
            )
            ->get();

        return view('cart.index', ['cart'=>$cart]);
    }

    public function cartListIndex() {
        $user = Auth::user();

        $cart = DB::table('carts')
            ->leftJoin('foods', 'carts.food_id', '=', 'foods.id')
            ->leftJoin('food_types', 'foods.type_id', '=', 'food_types.id')
            ->leftJoin('food_categories', 'foods.category_id', '=', 'food_categories.id')
            ->where('carts.user_uid', $user->uid)
            ->select(
                'carts.food_id as cart_food_id', 'carts.quantity as cart_quantity', 'carts.updated_at as cart_updated_at',
                'foods.category_id as food_category_id', 'foods.type_id as food_type_id', 'foods.name as food_name',
                'foods.price as food_price', 'food_categories.name as food_category_name', 'food_types.name as food_type_name'
            )
            ->get();

        return response(['record'=>$cart], 200);
    }

    public function cartModify(Request $request) {
        $user = Auth::user();

        $rules = [
            'action' => 'required|in:delete,add,clear',
            'food_id' => 'required|exists:App\Food,id'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response(
                ['message'=>$validator->errors()->getMessages()],
                400
            );
        }

        $cart_item = Cart::where('user_uid', $user->uid)->where('food_id', $request->food_id)->first();

        switch($request->action) {
            case 'add':
                $cart_item->quantity = $cart_item->quantity + 1;
                $cart_item->save();
                break;
            case 'delete':
                if ($cart_item->quantity > 1) {
                    $cart_item->quantity = $cart_item->quantity - 1;
                    $cart_item->save();
                } else {
                    $cart_item->delete();
                }
                break;
            case 'clear':
                $cart_item->delete();
                break;
        }

        return response(['message'=>'item updated'], 200);
    }

    public function cartStore(Request $request) {
        $user = Auth::user();

        $rules = [
            'food_id' => 'required|exists:App\Food,id'
        ];

        $validator = Validator::make($request->all(), $rules);

        $duplicate = Cart::where('user_uid', $user->uid)->where('food_id', $request->food_id)->first();

        if (!empty($duplicate)) {
            $duplicate->quantity = $duplicate->quantity + 1;
            $duplicate->save();
            $cart_item = Cart::where('user_uid', $user->uid)->where('food_id', $request->food_id)->first();
        } else {
            $cart_item = Cart::create([
                'user_uid' => $user->uid,
                'food_id' => $request->food_id,
                'quantity' => 1
            ]);
        }

        return response($cart_item, 201);
    }
}
