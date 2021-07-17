<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class Product extends Controller
{
    public function index()
    {
        $data = DB::table('products')
            ->join('categories', 'products.cat_id', 'categories.id')
            ->join('brands', 'products.brand_id', 'brands.id')
            ->select([
                'products.*',
                'categories.title as category_name',
                'brands.title as brand_name',
            ])
            ->paginate(10);

        return response()->json([
            'status_code' => 200,
            'msg' => 'success',
            'products' => $data,
        ], 200);

    }
    public function review()
    {
        $data = DB::table('product_reviews')
            ->join('products', 'product_reviews.product_id', 'products.id')
            ->join('users', 'product_reviews.user_id', 'users.id')
            ->paginate(10);

        return response()->json([
            'status_code' => 200,
            'msg' => 'success',
            'products_reviews' => $data,
        ], 200);
    }
}
