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
Route::get('products','Api\Product@index');
Route::get('product_reviews','Api\Product@review');
Route::get('banners','Api\Banner@index');
Route::get('brands','Api\Brand@index');

Route::get('carts','Api\Cart@index');
Route::post('carts/add','Api\Cart@add');
Route::get('wishlists','Api\Wishlist@index');
Route::post('wishlists/add','Api\Wishlist@add');

Route::post('login','Api\Login@index');
Route::post('register','Api\Register@index');
Route::get('users','Api\User@index');

