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

Route::get('products','Api\Product@index');
Route::get('categories','Api\Category@index');
Route::get('product_reviews','Api\Product@review');
Route::get('banners','Api\Banner@index');
Route::get('brands','Api\Brand@index');
Route::post('login','Api\Login@index');
Route::post('register','Api\Register@index');

