<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;


class User extends Controller
{
    public function index()
    {
        $data = DB::table('users')
            ->get();

        return response()->json([
            'status_code' => 200,
            'msg' => 'success',
            'users' => $data,
        ], 200);

    }
}
