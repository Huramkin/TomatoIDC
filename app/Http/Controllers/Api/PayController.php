<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class PayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pay(Request $request)
    {
        $this->validate($request,[

        ]);
    }
}
