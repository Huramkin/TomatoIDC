<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    protected $table = 'hosts';
    protected $fillable = ['order_id', 'user_id', 'host_name', 'host_pass', 'host_panel', 'host_url'];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function order()
    {
        return $this->hasOne('App\Order', 'id', 'order_id');
    }
}
