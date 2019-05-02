<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\TicketCollection;
use App\Ticket;
use App\TicketReply;
use Illuminate\Http\Request;

class TicketController extends Controller
{

    /**
     * 创建工单
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $this->validate(//数据认证
            $request, [
                'title' => 'string|min:3|max:200',
                'content' => 'string|min:3|max:999',
                'order_no' => 'exists:orders,no|nullable',
                'priority' => 'in:1,2,3|nullable'
            ]
        );
        //防止过多提交
        if (Ticket::where([['user_id', \Auth::id()], ['status', '!=', 3]])->get()->count() >= 50) {
            return ApiController::responseJson(0, 'Ticket Many');
        }
        //创建工单
        Ticket::create(
            [
                'title' => $request['title'],
                'content' => $request['content'],
                'user_id' => \Auth::id(),
                'order_no' => $request['order_no'],
                'priority' => $request['priority']
            ]
        );
        return ApiController::responseJson(1, 'Success');
    }

    /**
     * 工单回复
     * @param Request $request
     * @param Ticket $ticket
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function reply(Request $request, Ticket $ticket)
    {
        $this->validate(
            $request, [
                'content' => 'string|min:1|max:200'
            ]
        );
        //操作
        TicketReply::create(
            [
                'ticket_id' => $ticket->id,
                'content' => $request['content'],
                'user_id' => \Auth::id()
            ]
        );
        $ticket->update(['status' => 1]);

        return ApiController::responseJson(1, 'Success');
    }


    public function detail(Ticket $ticket)
    {
        return new \App\Http\Resources\Ticket($ticket);
    }

    public function show()
    {
        return new TicketCollection(Ticket::paginate());
    }
}
