<?php

namespace Tests\Feature;

use App\Ticket;
use App\User;
use EasyWeChat\Kernel\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTest extends TestCase
{

    public function testApiCreate()
    {
        $response = $this->post('/api/v1/tickets/create', [
            'title' => "工单创建测试" . Str::random(8),
            'content' => "工单创建测试" . Str::random(32),
            'priority' => mt_rand(1, 3),
            'api_token' => User::all()->first()->api_token
        ]);

        $response->assertJson(['status' => 1, 'msg' => "Success", 'data' => []]);
    }

    public function testApiReply()
    {
        $ticket = Ticket::all()->first();
        $resp = $this->post("api/v1/tickets/reply/{$ticket->id}", [
            'content'=>"工单回复测试" . Str::random(8),
            'api_token' => User::all()->first()->api_token
        ]);

        $resp->assertJson(['status' => 1, 'msg' => "Success", 'data' => []]);
    }

    public function testApiDetail()
    {
        $ticket = Ticket::all()->first();
        $resp = $this->get("api/v1/tickets/detail/{$ticket->id}?api_token=".User::all()->first()->api_token);
//        dd($resp);
        $resp->assertJson(['status' => 1, 'msg' => "Success", 'data' => []]);
    }
}
