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

Route::resource('items', 'ItemController');
Route::resource('categories', 'CategoryController');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function () {
    return view('welcome');
});

Route::get('products', 'PublicController@getProducts')->name('products');
Route::get('item/{id}', 'PublicController@getItem')->name('item');
Route::get('category/{id}', 'PublicController@getCategory')->name('category');

Route::get('cart', 'PublicController@getCart')->name('cart');
Route::get('add_to_cart/{id}', 'PublicController@add_to_cart')->name('add_to_cart');
Route::get('update_cart/{id}', 'PublicController@update_cart')->name('update_cart');
Route::get('remove_item/{id}', 'PublicController@remove_item')->name('remove_item');
Route::post('check_order', 'PublicController@check_order')->name('check_order');

Route::resource('orders', 'OrdersController');

Auth::routes();
