<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Order;


class Orders extends Controller
{
    public function index(Request $request)
    {
        $data = Order::with(array('cart_info'))
            ->where('user_id', $request->user_id)
            ->get();
        return response()->json([
            'status_code' => 200,
            'msg' => 'success',
            'orders' => $data,
        ], 200);
    }
}
