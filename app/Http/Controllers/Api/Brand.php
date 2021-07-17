<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;


class Brand extends Controller
{
    public function index()
    {
        $data = DB::table('brands')
            ->get();

        return response()->json([
            'status_code' => 200,
            'msg' => 'success',
            'brands' => $data,
        ], 200);

    }
}
