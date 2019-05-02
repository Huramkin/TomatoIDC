<?php

namespace Tests\Feature;

use App\Coupon;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponTest extends TestCase
{
    public function testUse()
    {
        Coupon::create([
            'key'=>'wdnmd',
            'type'=>'percentage',
            'offer'=>'20',
            'use_date'=>Carbon::now(),
            'deadline'=>Carbon::now()->addDay(),
            'goods_id'=>null,
        ]);
    }
}
