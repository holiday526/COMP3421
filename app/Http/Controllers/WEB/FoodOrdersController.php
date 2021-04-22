<?php

namespace App\Http\Controllers\WEB;

use App\Cart;
use App\Events\NewOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\FoodOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FoodOrdersController extends Controller
{
    //

    public function __construct() {
        $this->middleware('auth');
    }

    public function orderIndex() {
        $user = Auth::user();
        $order_ids = DB::table('food_orders')
            ->where('user_uid', $user->uid)
            ->groupBy('order_id')
            ->orderBy('order_id', 'desc')
            ->pluck('order_id')
            ->toArray();
        return view('order.index', ['order_ids'=>$order_ids]);
    }

    public function orderCount() {
        $user = Auth::user();
        $food_orders = DB::table('food_orders')->select('order_id')->where('user_uid', $user->uid)->groupBy('order_id')->get();
        return response(['order_count'=>count($food_orders)], 200);
    }

    public function orderShow($order_id) {
        $user = Auth::user();
        $order = DB::table('food_orders')
            ->where('user_uid', $user->uid)
            ->where('order_id', $order_id)
            ->get();

        if (count($order) === 0) {
            return response(['message'=>'no order is found'], 404);
        }

        return response(['order'=> $order], 200);

    }

    public function orderStore(Request $request) {
        $user = Auth::user();

        $cart_items = Cart::where('user_uid', $user->uid)->get();

        if (count($cart_items) === 0) {
            return response(['message'=>'no items in cart'], 400);
        }

        $lastest_order = FoodOrder::orderBy('order_id', 'desc')->first();

        if (empty($lastest_order)) {
            $order_id = 1;
        } else {
            $order_id = $lastest_order->order_id + 1;
        }

        foreach($cart_items as $cart_item) {
            FoodOrder::create([
                'order_id' => $order_id,
                'user_uid' => $user->uid,
                'food_id' => $cart_item->food_id,
                'quantity' => $cart_item->quantity,
                'processed' => false,
            ]);
            $cart_item->delete();
        }

        event(new NewOrder($order_id));

        return response(['order_id'=>$order_id], 201);
    }

    public function orderTotalPrice($order_id) {
        $user = Auth::user();

        $orders = DB::table('food_orders')
            ->leftJoin('foods', 'food_orders.food_id', '=', 'foods.id')
            ->where('user_uid', $user->uid)
            ->where('order_id', $order_id)
            ->select('food_orders.food_id', 'foods.price', 'food_orders.quantity')
            ->get();

        if (count($orders) === 0) {
            return response(['message'=>'no order is found'], 404);
        }

        $total = 0;

        foreach ($orders as $order) {
            $total += $order->price * $order->quantity;
        }

        return response(['total_price'=> $total], 200);
    }
}
