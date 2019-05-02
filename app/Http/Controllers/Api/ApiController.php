<?php

namespace App\Http\Controllers\Api;

use App\Goods;
use App\Http\Resources\GoodsCollection;

class ApiController extends Controller
{
    public static function responseJson(int $status, string $msg, array $data=[])
    {
            return response()
                ->json(['status' => $status, 'msg' => $msg,'data'=>$data]);
    }
}
