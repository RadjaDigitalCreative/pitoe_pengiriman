<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('categories','Api\Category@index');
Route::get('categories/get/{id}','Api\Category@get');
Route::get('products','Api\Product@index');
Route::get('products/get/{id}','Api\Product@get');
Route::get('products/category/{id}','Api\Product@category');
Route::get('product_reviews','Api\Product@review');
Route::get('banners','Api\Banner@index');
Route::get('brands','Api\Brand@index');

Route::get('carts','Api\Cart@index');
Route::get('carts/get/{id}','Api\Cart@get');
Route::get('carts/user/{id}','Api\Cart@user');
Route::post('carts/add','Api\Cart@add');
Route::post('carts/update/qty','Api\Cart@qty');
Route::post('carts/delete','Api\Cart@delete');

Route::get('wishlists','Api\Wishlist@index');
Route::get('wishlists/get/{id}','Api\Wishlist@get');
Route::get('wishlists/user/{id}','Api\Wishlist@user');
Route::post('wishlists/add','Api\Wishlist@add');
Route::post('wishlists/update/qty','Api\Wishlist@qty');
Route::post('wishlists/delete','Api\Wishlist@delete');
Route::post('wishlists/toCart','Api\Wishlist@toCart');

Route::post('login','Api\Login@index');
Route::post('register','Api\Register@index');
Route::get('users','Api\User@index');

