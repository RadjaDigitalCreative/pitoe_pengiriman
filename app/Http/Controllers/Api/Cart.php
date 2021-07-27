<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;


class Cart extends Controller
{
    public function index()
    {
        $data = DB::table('carts')
            ->join('products', 'carts.product_id', 'products.id')
            ->join('users', 'carts.user_id', 'users.id')
            ->select([
                'carts.*',
                'products.title as product_name',
                'products.photo as product_image',
                'users.name as username',
            ])
            ->get();

        return response()->json([
            'status_code' => 200,
            'msg' => 'success',
            'carts' => $data,
        ], 200);

    }

    public function get($id)
    {
        $data = DB::table('carts')
            ->join('products', 'carts.product_id', 'products.id')
            ->join('users', 'carts.user_id', 'users.id')
            ->where('carts.id', $id)
            ->select([
                'carts.*',
                'products.title as product_name',
                'products.photo as product_image',
                'users.name as username',
            ])
            ->get();

        return response()->json([
            'status_code' => 200,
            'msg' => 'success',
            'carts' => $data,
        ], 200);

    }

    public function user($id)
    {
        $data = DB::table('carts')
            ->join('products', 'carts.product_id', 'products.id')
            ->join('users', 'carts.user_id', 'users.id')
            ->where('carts.user_id', $id)
            ->select([
                'carts.*',
                'products.title as product_name',
                'products.photo as product_image',
                'users.name as username',
            ])
            ->get();

        return response()->json([
            'status_code' => 200,
            'msg' => 'success',
            'carts' => $data,
        ], 200);

    }

    public function add(Request $request)
    {
        try {
            $cart = DB::table('carts')->where('product_id', $request->product_id)
                ->where('user_id', $request->user_id)->first();
            if ($cart == TRUE) {
                $data = DB::table('carts')
                    ->where('product_id', $request->product_id)
                    ->where('user_id', $request->user_id)
                    ->update([
                        'price' => $request->price + $cart->price,
                        'quantity' => $request->quantity + $cart->quantity,
                        'amount' => $request->amount + $cart->amount,
                    ]);
            } else {
                $data = DB::table('carts')
                    ->insert([
                        'product_id' => $request->product_id,
                        'user_id' => $request->user_id,
                        'price' => $request->price,
                        'status' => $request->status,
                        'quantity' => $request->quantity,
                        'amount' => $request->amount,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
            }

            return response()->json([
                'status_code' => 201,
                'msg' => 'success',
                'add_cart' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

    }

    public function qty(Request $request)
    {
        try {
            $cart = DB::table('carts')->where('product_id', $request->product_id)
                ->where('user_id', $request->user_id)->first();
            if ($cart == TRUE) {
                $data = DB::table('carts')
                    ->where('product_id', $request->product_id)
                    ->where('user_id', $request->user_id)
                    ->update([
                        'price' => $request->price,
                        'quantity' => $request->quantity,
                        'amount' => $request->amount,
                    ]);
            } else {
                return response()->json([
                    'status_code' => 401,
                    'msg' => 'Not Found',
                    'update_qty_cart' => 'Not Success',
                ], 200);
            }
            return response()->json([
                'status_code' => 201,
                'msg' => 'success',
                'update_qty_cart' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());

        }
    }

    public function delete(Request $request)
    {
        try {
            $cart = DB::table('carts')->where('product_id', $request->product_id)
                ->where('user_id', $request->user_id)->first();
            if ($cart == TRUE) {
                $data = DB::table('carts')
                    ->where('product_id', $request->product_id)
                    ->where('user_id', $request->user_id)
                    ->delete();
            }
            return response()->json([
                'status_code' => 201,
                'msg' => 'success',
                'delete_cart' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
