<?php

namespace App\Http\Resources;

use App\Order;
use App\User;
use App\Ticket;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AdminIndexCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'code'=>0,
            'msg'=>'Success',
            'data'=> [
                'servers'=>$this->collection,
                'userCount'=>User::all()->count(),
                'orderCount'=>Order::all()->count(),
                'workOrderCount'=>Ticket::where('status','1')->count()
            ]
        ];
    }
}
