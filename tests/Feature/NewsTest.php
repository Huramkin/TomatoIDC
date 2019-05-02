<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewsTest extends TestCase
{
    //TODO 减轻依赖

    public function testPage()
    {
        $str = Str::random(16);
        $id = DB::table('news')->insert(
            [
                'title' => $str,
                'subtitle' => $str ,
                "description"=>$str
            ]
        );
        $resp = $this->get("/page/".$str);
        $resp->assertSeeText("test");

        DB::table('diy_page')->where("hash",$str)->delete();
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
        DB::table('diy_page')->where("hash",$str)->delete();
    }

    public function testDelPage()
    {
        $str =  Str::random(6);
        DB::table('diy_page')->insert(
            ['hash' => $str, 'content' => "test"]
        );

        $user = User::where("admin_authority","1")->first();//选取第一个管理员用户
        $response = $this->actingAs($user)
            ->post('/admin/diy/page/del',[
                "_token"=>csrf_token(),
                "hash" =>$str,
            ]);
        $response->assertRedirect("/admin/diy/page/show");
        DB::table('diy_page')->where("hash",$str)->delete();
    }

    public function testEditPage()
    {
        $str =  Str::random(6);
        DB::table('diy_page')->insert(
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
        DB::table('diy_page')->where("hash",$str)->delete();
    }

}
