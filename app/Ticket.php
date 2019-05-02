<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['title', 'content', 'user_id','order_no','priority'];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function reply()
    {
        return $this->hasMany('App\TicketReply','ticket_id','id');
    }
}
