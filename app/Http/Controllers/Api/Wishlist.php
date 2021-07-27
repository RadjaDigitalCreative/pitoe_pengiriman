<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;


class Wishlist extends Controller
{
    public function index()
    {
        $data = DB::table('wishlists')
            ->join('products', 'wishlists.product_id', 'products.id')
            ->join('users', 'wishlists.user_id', 'users.id')
            ->select([
                'wishlists.*',
                'products.title as product_name',
                'products.photo as product_image',
                'users.name as username',
            ])
            ->get();

        return response()->json([
            'status_code' => 200,
            'msg' => 'success',
            'wishlists' => $data,
        ], 200);

    }

    public function get($id)
    {
        $data = DB::table('wishlists')
            ->join('products', 'wishlists.product_id', 'products.id')
            ->join('users', 'wishlists.user_id', 'users.id')
            ->where('wishlists.id', $id)
            ->select([
                'wishlists.*',
                'products.title as product_name',
                'products.photo as product_image',
                'users.name as username',
            ])
            ->get();

        return response()->json([
            'status_code' => 200,
            'msg' => 'success',
            'wishlists' => $data,
        ], 200);

    }

    public function user($id)
    {
        $data = DB::table('wishlists')
            ->join('products', 'wishlists.product_id', 'products.id')
            ->join('users', 'wishlists.user_id', 'users.id')
            ->where('wishlists.user_id', $id)
            ->where('wishlists.status', NULL)
            ->select([
                'wishlists.*',
                'products.title as product_name',
                'products.photo as product_image',
                'users.name as username',
            ])
            ->get();

        return response()->json([
            'status_code' => 200,
            'msg' => 'success',
            'wishlists' => $data,
        ], 200);

    }

    public function add(Request $request)
    {
        try {
            $cart = DB::table('wishlists')->where('product_id', $request->product_id)
                ->where('user_id', $request->user_id)->first();
            if ($cart == TRUE) {
                $data = DB::table('wishlists')
                    ->where('product_id', $request->product_id)
                    ->where('user_id', $request->user_id)
                    ->update([
                        'price' => $request->price + $cart->price,
                        'quantity' => $request->quantity + $cart->quantity,
                        'amount' => $request->amount + $cart->amount,
                    ]);
            } else {
                $data = DB::table('wishlists')
                    ->insert([
                        'product_id' => $request->product_id,
                        'user_id' => $request->user_id,
                        'price' => $request->price,
                        'quantity' => $request->quantity,
                        'amount' => $request->amount,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
            }

            return response()->json([
                'status_code' => 201,
                'msg' => 'success',
                'add_wishlists' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function toCart(Request $request)
    {
        try {
                $cart = DB::table('wishlists')->where('product_id', $request->product_id)->where('user_id', $request->user_id)->first();
                $cart2 = DB::table('carts')->where('product_id', $request->product_id)->where('user_id', $request->user_id)->first();
                if ($cart2 == TRUE) {
                    $data = DB::table('carts')
                        ->where('product_id', $request->product_id)
                        ->where('user_id', $request->user_id)
                        ->update([
                            'price' => $cart2->price + $cart->price,
                            'quantity' => $cart2->quantity + $cart->quantity,
                            'amount' => $cart2->amount + $cart->amount,
                            'status' => 1,
                        ]);
                    DB::table('wishlists')->where('product_id', $request->product_id)->where('user_id', $request->user_id)->update([
                        'status' => 1,
                    ]);
                } elseif ($cart2 == FALSE) {
                    $data = DB::table('carts')
                        ->insert([
                            'product_id' => $cart->product_id,
                            'user_id' => $cart->user_id,
                            'price' => $cart->price,
                            'quantity' => $cart->quantity,
                            'amount' => $cart->amount,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    DB::table('wishlists')->where('product_id', $request->product_id)->where('user_id', $request->user_id)->update([
                        'status' => 1,
                    ]);
            }
            return response()->json([
                'status_code' => 201,
                'msg' => 'success',
                'add_wishlists_to_cart' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function qty(Request $request)
    {
        try {
            $cart = DB::table('wishlists')->where('product_id', $request->product_id)
                ->where('user_id', $request->user_id)->first();
            if ($cart == TRUE) {
                $data = DB::table('wishlists')
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
                'update_qty_wishlist' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());

        }
    }

    public function delete(Request $request)
    {
        try {
            $cart = DB::table('wishlists')->where('product_id', $request->product_id)
                ->where('user_id', $request->user_id)->first();
            if ($cart == TRUE) {
                $data = DB::table('wishlists')
                    ->where('product_id', $request->product_id)
                    ->where('user_id', $request->user_id)
                    ->delete();
            }

            return response()->json([
                'status_code' => 201,
                'msg' => 'success',
                'delete_wishlist' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());

        }
    }
}
