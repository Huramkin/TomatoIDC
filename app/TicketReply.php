<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{
    protected $fillable = ['ticket_id', 'content', 'user_id'];
    protected $table = 'tickets_reply';

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function ticket()
    {
        return $this->hasOne('App\Ticket','id','ticket_id');
    }
}
