<?php

namespace App\Http\Controllers\Api;

use App\Host;
use App\Http\Requests\OrderCreate;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function push(Request $request)
    {
        $this->validate($request, [
            'host_id' => 'required|exists:host,id',
            'user_email' => 'required|exists:users,email',
        ]);
        $host = Host::find($request['host_id']);
        $this->authorize('push', $host);


    }

    public function create(OrderCreate $request)
    {
        switch ($request['type']) {
            case "goods":

                break;

        }


    }

    public function destroy(Request $request)
    {

    }

    public function update(Request $request)
    {

    }

    public function show()
    {

    }
}
