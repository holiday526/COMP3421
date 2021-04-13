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

Route::get('/login/admin', 'Auth\LoginController@adminLoginForm')->name('admin-login');
//Route::get('/register/admin', 'Auth\RegisterController@adminRegisterForm');

Route::post('/login/admin', 'Auth\LoginController@adminLogin');
//Route::post('/register/admin', 'Auth\RegisterController@createAdmin');

// Route::view('/home', 'home')->middleware('auth');
Route::view('/admin', 'admin')->middleware('admin-auth');