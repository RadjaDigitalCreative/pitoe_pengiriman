<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;


class Login extends Controller
{
    public function index(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $data = DB::table('users')
                ->where('email' ,'=' , $credentials)
                ->first();
                return response()->json([
                    'status_code'   => 200,
                    'msg'           => 'success',
                    'customers' => $data,
                ], 200);
        }else{
            return response()->json([
                'status_code'   => 200,
                'msg'           => 'not found',
                'username' => 'tidak ditemukan',
            ], 200);
        }
    }
}
