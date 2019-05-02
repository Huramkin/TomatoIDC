<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public static function makeApiMsg(int $code= 0,string $msg=null,$data=null)
    {
        return response()
            ->json(['code' => $code, 'msg' =>$msg,'data'=>$data]);
    }
}
