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


/**
 * admin page
 */
Route::get('/login/admin', 'Auth\LoginController@adminLoginForm')->name('admin-login');
Route::get('/register/admin', 'Auth\RegisterController@adminRegisterForm');

Route::post('/login/admin', 'Auth\LoginController@adminLogin');
Route::post('/register/admin', 'Auth\RegisterController@createAdmin');

Route::get('/admin/food', 'WEB\admin\FoodsController@foodCreate');
Route::post('/admin/food', 'WEB\admin\FoodsController@foodStore');

Route::get('/admin/food_type', 'WEB\admin\FoodsController@foodTypesCreate');
Route::post('/admin/food_type', 'WEB\admin\FoodsController@foodTypesStore');

Route::get('/admin/food_category', "WEB\admin\FoodsController@foodCategoryCreate");
Route::post('/admin/food_category', "WEB\admin\FoodsController@foodCategoryStore");

Route::view('/admin', 'admin')->middleware('admin-auth');
