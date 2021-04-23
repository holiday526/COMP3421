<?php

namespace App\Http\Controllers\WEB\admin;

use App\Events\ItemProcessed;
use App\Events\NotifyUser;
use App\FoodOrder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodOrdersController extends Controller
{
    //
    public function __construct() {
        $this->middleware('admin-auth');
    }

    public function foodOrderList() {
//        $food_orders = FoodOrder::orderBy('order_id', 'desc')->get();
        $food_orders = DB::table('food_orders')
            ->leftJoin('foods', 'food_orders.food_id', '=', 'foods.id')
            ->select(
                'food_orders.order_id as order_id', 'food_orders.user_uid as user_uid', 'food_orders.food_id as food_id',
                'food_orders.quantity as quantity', 'food_orders.processed as processed', 'food_orders.updated_at as order_updated_at',
                'foods.name as food_name'
            )
            ->orderBy('order_id', 'desc')->get();
        return response(['orders'=>$food_orders], 200);
    }

    public function foodOrderIndex() {
        return view('admin.food_order.index');
    }

    public function foodOrderItemUpdate(Request $request) {
        $rules = [
            'food_id' => 'required|exists:App\Food,id',
            'order_id' => 'required|exists:App\FoodOrder,order_id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response(['message'=>$validator->errors()->getMessages()], 400);
        }

        $item_processed = FoodOrder::where('food_id', $request->food_id)->where('order_id', $request->order_id)->first()->processed;

        if ($item_processed) {
            $order = FoodOrder::where('food_id', $request->food_id)->where('order_id', $request->order_id)->update(['processed'=>false]);
        } else {
            $order = FoodOrder::where('food_id', $request->food_id)->where('order_id', $request->order_id)->update(['processed'=>true]);
        }

        event(new ItemProcessed($request->order_id));

        return response(['item'=>$order], 202);

    }

    public function foodOrderNotifyUsers(Request $request) {
        $rules = [
            'user_uid' => 'exists:App\User,uid|required',
            'order_id' => 'required|exists:App\FoodOrder,order_id'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response($validator->errors()->getMessages());
        }
        event(new NotifyUser($request->user_uid, $request->order_id));
        return response(['status'=>'success'], 200);
    }
}
