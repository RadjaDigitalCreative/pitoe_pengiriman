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
            ->select([
                'products.*',
                'categories.title as category_name',
            ])
            ->paginate(10);

        return response()->json([
            'status_code' => 200,
            'msg' => 'success',
            'products' => $data,
        ], 200);

    }

    public function get($id)
    {
        $data = DB::table('products')
            ->join('categories', 'products.cat_id', 'categories.id')
            ->select([
                'products.*',
                'categories.title as category_name',
            ])
            ->where('products.id', $id)
            ->get();

        return response()->json([
            'status_code' => 200,
            'msg' => 'success',
            'products' => $data,
        ], 200);

    }

    public function category($id)
    {
        $data = DB::table('products')
            ->join('categories', 'products.cat_id', 'categories.id')
            ->select([
                'products.*',
                'categories.title as category_name',
            ])
            ->where('products.cat_id', $id)
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
