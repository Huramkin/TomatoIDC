<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPageTest extends TestCase
{
    /**
     * 测试页面是否正常返回
     * A basic feature test example.
     *
     * @return void
     */

    //首页
    public function testIndex()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testGoodShow()
    {

        $response = $this->get('/goods/show');
        $response->assertStatus(200);
    }

    //登录页
    public function testLogin()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    //注册页
    public function testRegister()
    {

        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    //用户页
    public function testUserProfile()
    {

        $response = $this->actingAs(User::all()->first())
            ->get('/home/user/profile');
        $response->assertStatus(200);
    }

    //充值页
    public function testUserRecharge()
    {

        $response = $this->actingAs(User::all()->first())
            ->get('/home/user/recharge');
        $response->assertStatus(200);
    }

    //订单列表
    public function testOrderShow()
    {

        $response = $this->actingAs(User::all()->first())
            ->get('/home/order/show');
        $response->assertStatus(200);
    }

    //新闻页
    public function testNewShow()
    {
        $response = $this->actingAs(User::all()->first())
            ->get('/home/new/show');
        $response->assertStatus(200);
    }

    //主机列表
    public function testHostShow()
    {
        $response = $this->actingAs(User::all()->first())
            ->get('/home/host/show');
        $response->assertStatus(200);
    }

    //工单列表
    public function testWorkorderShow()
    {
        $response = $this->actingAs(User::all()->first())
            ->get('/home/workorder/show');
        $response->assertStatus(200);
    }

    //用户列表
    public function testHome()
    {
        $response = $this->actingAs(User::all()->first())
            ->get('/home');
        $response->assertStatus(200);
    }
}
