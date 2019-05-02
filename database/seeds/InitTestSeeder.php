<?php

use Illuminate\Database\Seeder;

class InitTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
                'email' => 'yf@rbq.ai',
                'password' => Hash::make('12345678'),
                'name' => 'yfsama',
                'username' => 'yfsama',
                'api_token' => Str::random(60),
            ]
        );

        \App\Goods::create([
            'title'=>"商品测试数据填充".date('Y-m-d H:i:s'),
            'type'=>'server',
        ]);

        \App\Coupon::create([
            'key'=>'wdnmd',
            'type'=>'percentage',
            'offer'=>'20',
            'use_date'=>\Carbon\Carbon::now(),
            'deadline'=>\Carbon\Carbon::now()->addDay(),
            'goods_id'=>null,
        ]);

        \App\Server::create([
           'title'=>'服务器测试填充',
           'ip'=>'1.1.1.1',
           'token'=>'key',
           'key'=>'key',
           'port'=>'114514',
           'plugin'=>null,
            'type'=>'server'

        ]);

        \App\Order::create([
            'goods_id'=>1,
            'title'=>'订单测试数据填充'.date('Y-m-d H:i:s'),
            'user_id'=>1,
            'coupon'=>'wdnmd',
            'type'=>'goods',
            'sale'=>0,
            'price'=>0,
        ]);

        \App\Ticket::create([
            'title' => "工单测试数据填充".date('Y-m-d H:i:s'),
            'content' => "测试数据填充".date('Y-m-d H:i:s'),
            'user_id' => 1,
            'order_no' => 1,
            'priority' => mt_rand(0,2),
            ]);


    }
}
