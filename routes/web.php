<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/food_menu', 'WEB\FoodsController@foodIndex');
Route::get('/food', 'WEB\FoodsController@foodShow');
Route::get('/food_search', 'WEB\FoodsController@foodSearch');

/**
 * admin page
 */
Route::get('/login/admin', 'Auth\LoginController@adminLoginForm')->name('admin-login');
Route::get('/register/admin', 'Auth\RegisterController@adminRegisterForm');

Route::post('/login/admin', 'Auth\LoginController@adminLogin');
Route::post('/register/admin', 'Auth\RegisterController@createAdmin');

Route::view('/admin', 'admin.admin')->middleware('admin-auth');

Route::middleware(['admin-auth'])->group(function() {
    Route::get('/admin/food/edit/{food_id}', 'WEB\admin\FoodsController@foodEdit');
    Route::post('/admin/food/delete', 'WEB\admin\FoodsController@foodDelete');
    Route::get('/admin/food/edit', 'WEB\admin\FoodsController@foodIndex');
    Route::get('/admin/food/list', 'WEB\admin\FoodsController@foodListIndex');
    Route::post('/admin/food/restore', 'WEB\admin\FoodsController@foodRestore');
    Route::post('/admin/food/update', 'WEB\admin\FoodsController@foodUpdate');
    Route::get('/admin/food', 'WEB\admin\FoodsController@foodCreate');
    Route::post('/admin/food', 'WEB\admin\FoodsController@foodStore');

    Route::get('/admin/food_type', 'WEB\admin\FoodsController@foodTypesCreate');
    Route::post('/admin/food_type', 'WEB\admin\FoodsController@foodTypesStore');

    Route::get('/admin/food_category', "WEB\admin\FoodsController@foodCategoryCreate");
    Route::post('/admin/food_category', "WEB\admin\FoodsController@foodCategoryStore");

    Route::post('/admin/order/item/update', "WEB\admin\FoodOrdersController@foodOrderItemUpdate");
    Route::get('/admin/order/list', "WEB\admin\FoodOrdersController@foodOrderList");
    Route::post('/admin/order/notify', "WEB\admin\FoodOrdersController@foodOrderNotifyUsers");
    Route::get('/admin/order', "WEB\admin\FoodOrdersController@foodOrderIndex");
});

Route::middleware(['auth'])->group(function() {
    Route::get('/profile', 'WEB\ProfilesController@profileShow');
});

Route::middleware(['auth'])->group(function() {
    Route::get('/cart/list', 'WEB\CartsController@cartListIndex');
    Route::post('/cart/modify', 'WEB\CartsController@cartModify');
    Route::get('/cart', 'WEB\CartsController@cartIndex');
    Route::post('/cart', 'WEB\CartsController@cartStore');
});

Route::middleware(['auth'])->group(function() {
    Route::get('/order/price/{order_id}', 'WEB\FoodOrdersController@orderTotalPrice');
    Route::get('/order/{order_id}', 'WEB\FoodOrdersController@orderShow');
    Route::get('/order/count', 'WEB\FoodOrdersController@orderCount');
    Route::get('/order', 'WEB\FoodOrdersController@orderIndex');
    Route::post('/order', 'WEB\FoodOrdersController@orderStore');
});
