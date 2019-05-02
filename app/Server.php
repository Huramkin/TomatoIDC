<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $table = 'servers';
    protected $fillable = ['title', 'ip', 'key', 'plugin', 'port','token','username','password'];

    public function order()
    {
        return $this->belongsTo('App\Goods', 'server_id', 'id');
    }

//    public function host()
//    {
//        return $this->hasMany('App\Host', 'server_id', 'id');
//    }

//    public function getHosts()
//    {
//        return $this->hasMany('S')
//    }
}
