<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function recharge(Request $request)
    {
        $this->validate($request,[
           'price'=>'numeric|required',
            'payment'=>'in:wechat,alipay,diy,qqpay|string|required',
        ]);

        $price =round(abs($request->money),2);

    }

    public function pay(Request $request)
    {
        $this->validate($request,[

        ]);
    }
}
