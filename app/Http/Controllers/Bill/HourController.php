<?php

namespace App\Http\Controllers\Bill;

use Illuminate\Http\Request;

class HourController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pay(Request $request)
    {
        $this->validate($request,[
            'price'=>''
        ]);
    }

    public static function bill()
    {

    }

    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    }

}
