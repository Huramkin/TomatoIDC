<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * 返回创建用户名
     * @return array
     */
    protected function createUser()
    {
        $password = "a12345678";
        $name = "test_".Str::random(8);
        $resp = $this->post("/register",[
            "name"=>$name,
            "username"=>$name,
            "email"=>"{$name}@mercycloud.com",
            "password"=>$password,
            "password_confirmation"=>$password,
            "agreement"=>"1",
        ]);

        return [
            "name"=>$name,
            "password" => $password,
            "resp" => $resp
        ];
    }

    //注册测试
    public function testRegister()
    {
        $cUser = $this->createUser();
        $resp = $cUser['resp'];

        $resp->assertRedirect("/home");
    }

    //登陆测试
    public function testLogin()
    {
        $cUser = $this->createUser();
        \Auth::logout();
        $resp = $this->post("/login",[
            "email"=>"{$cUser['name']}@mercycloud.com",
            "password"=>$cUser['password'],
            "remember"=>"1"
        ]);
        dd($resp->exception);
        $resp->assertRedirect("/home");
    }

    //登出测试
    public function testLogout()
    {
        $cUser = $this->createUser();

        $this->post("/logout",[]);

       $this->assertGuest();
    }

}
