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
            ->join('products' ,'carts.product_id', 'products.id')
            ->join('users' ,'carts.user_id', 'users.id')
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
    public function add(Request $request){
        try{
            $count = count($request->product_id);
            for($i = 0; $i <$count; $i++){
                $cart = DB::table('carts')->where('product_id' , $request->product_id[$i])->first();
                if ($cart == TRUE ){
                    $data = DB::table('carts')
                        ->where('product_id' , $request->product_id[$i])
                        ->update([
                            'price' => $request->price[$i] + $cart->price,
                            'quantity' => $request->quantity[$i] + $cart->quantity,
                            'amount' => $request->amount[$i] + $cart->amount,
                        ]);
                }else{
                    $data = DB::table('carts')
                        ->insert([
                            'product_id' => $request->product_id[$i],
                            'user_id' => $request->user_id[$i],
                            'price' => $request->price[$i],
                            'status' => $request->status[$i],
                            'quantity' => $request->quantity[$i],
                            'amount' => $request->amount[$i],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                }
            }
            return response()->json([
                'status_code' => 201,
                'msg' => 'success',
                'add_cart' => $data,
            ], 200);
        }catch(\Exception $e){
            $e->getMessage();
        }

    }
}
