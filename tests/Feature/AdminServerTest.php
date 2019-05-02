<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminServerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAddServer()
    {
        $user = User::where("admin_authority","1")->first();//选取第一个管理员用户
        $response = $this->actingAs($user)
            ->post('/admin/diy/page/edit',[
                "_token"=>csrf_token(),
                "hash" =>$str,
                "content" =>$str,
            ]);
        $response->assertRedirect("/admin/diy/page/show");
        DB::table('diy_page')->where("hash",$str)->delete();
    }
}
