<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'key',
        'type',
        'goods_id',
        'condition',
        'offer',
        'use_date',
        'deadline'
    ];

    protected $table = 'coupons';
}
