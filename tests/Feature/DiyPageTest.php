<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DiyPageTest extends TestCase
{
    use WithoutMiddleware;
    //TODO 减轻依赖

    public function testPage()
    {
        $str = Str::random(6);
        DB::table('diy_pages')->insert(
            ['hash' => $str, 'content' => "test"]
        );
        $resp = $this->get("/page/".$str);
        $resp->assertSeeText("test");

        DB::table('diy_pages')->where("hash",$str)->delete();
    }

    public function testAddPage()
    {
        $user = User::where("admin_authority","1")->first();//选取第一个管理员用户
        $str =  Str::random(6);

        $response = $this->actingAs($user)
            ->post('/admin/diy/page/add',[
                "_token"=>csrf_token(),
                "hash" =>$str,
                "content" => $str
            ]);
        $response->assertRedirect("/admin/diy/page/show");
        DB::table('diy_pages')->where("hash",$str)->delete();
    }

    public function testDelPage()
    {
        $str =  Str::random(6);
        DB::table('diy_pages')->insert(
            ['hash' => $str, 'content' => "test"]
        );

        $user = User::where("admin_authority","1")->first();//选取第一个管理员用户
        $response = $this->actingAs($user)
            ->post('/admin/diy/page/del',[
                "_token"=>csrf_token(),
                "hash" =>$str,
            ]);
        $response->assertRedirect("/admin/diy/page/show");
        DB::table('diy_pages')->where("hash",$str)->delete();
    }

    public function testEditPage()
    {
        $str =  Str::random(6);
        DB::table('diy_pages')->insert(
            ['hash' => $str, 'content' => "test"]
        );

        $user = User::where("admin_authority","1")->first();//选取第一个管理员用户
        $response = $this->actingAs($user)
            ->post('/admin/diy/page/edit',[
                "_token"=>csrf_token(),
                "hash" =>$str,
                "content" =>$str,
            ]);
        $response->assertRedirect("/admin/diy/page/show");
        DB::table('diy_pages')->where("hash",$str)->delete();
    }


}
