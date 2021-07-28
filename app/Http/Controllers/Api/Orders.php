<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\Models\Order;
use Illuminate\Support\Str;


class Orders extends Controller
{
    public function index(Request $request)
    {
        try{
            $data = Order::with(array('cart_info'))
                ->where('user_id', $request->user_id)
                ->get();
            return response()->json([
                'status_code' => 200,
                'msg' => 'success',
                'orders' => $data,
            ], 200);
        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }
    }
    public function create(Request $request)
    {
        try{
            $cart = DB::table('carts')->where('user_id', $request->user_id)->where('order_id', NULL)->get();
            $akses = DB::table('carts')->where('user_id', $request->user_id)->where('order_id', NULL)->count();
            if ($akses > 0){
                $sub_total = 0;
                $qty = 0;
                foreach($cart as $row){
                    $quantity = $row->price * $row->quantity;
                    $qty  += $row->quantity;
                    $sub_total += $quantity;
                }
                $total_amount = $sub_total+$request->shipping_amount;
                $data = DB::table('orders')->insert([
                    'order_number' => 'ORD-'.strtoupper(Str::random(10)),
                    'user_id' => $request->user_id,
                    'sub_total'  => $sub_total,
                    'shipping_id' => 5,
                    'shipping_amount' => $request->shipping_amount,
                    'courier' => $request->courier,
                    'total_amount' => $total_amount,
                    'quantity' => $qty,
                    'payment_method' => $request->payment_method,
                    'payment_status' => 'unpaid',
                    'status' => 'new',
                    'first_name' => $request->first_name,
                    'last_name' => $request->lastname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'country' => 'ID',
                    'post_code' => $request->post_code,
                    'address1' => $request->address,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                $id = DB::getPdo()->lastInsertId();
                DB::table('carts')->where('user_id', $request->user_id)->update([
                    'order_id' => $id
                ]);
                return response()->json([
                    'status_code' => 200,
                    'msg' => 'success',
                    'orders' => $data,
                ]);
            }else{
                return response()->json([
                    'status_code' => 403,
                    'msg' => 'not found',
                ]);
            }
        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }
    }
}
