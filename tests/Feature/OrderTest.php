<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    protected $user;



    public function testBuy()
    {
        $user = factory(User::class)->create();
        $resp  = $this->actingAs($user)
            ->post("",[

            ]);
    }
}
