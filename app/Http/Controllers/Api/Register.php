<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;


class Register extends Controller
{
    public function index(Request $request)
    {
        $data = DB::table('users')
            ->where('email' ,'=' , $request->email)
            ->first();
        if ($data == FALSE) {
            $response = DB::table('users')
                ->insert([
                    'name' =>$request->name,
                    'password' => Hash::make($request->password),
                    'email' =>$request->email,
                    'status' => 'active',
                    'role' => 'user',
                    'provider' => 'google',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            return response()->json([
                'status_code' => 200,
                'msg' => 'success',
                'users' => $response,
            ], 200);
        } else {
            return response()->json([
                'status_code' => 409,
                'msg' => 'Email Sudah Ada',
                'users' => 'Not Success',
            ], 200);
        }
    }
}
