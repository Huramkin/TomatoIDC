<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['goods_id', 'title', 'user_id', 'coupon','status', 'type','sale','price','remark'];

    public function good()
    {
        return $this->hasOne('App\Goods', 'id', 'goods_id');
    }

    public function host()
    {
        return $this->hasOne('App\Host', 'id', 'host_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
