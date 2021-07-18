<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;


class Category extends Controller
{
    public function index()
    {
        $data = DB::table('categories')
            ->get();

        return response()->json([
            'status_code' => 200,
            'msg' => 'success',
            'products' => $data,
        ], 200);

    }
}
