<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setup extends Model
{
    protected $table = 'setups';
    protected $fillable = ['title', 'value'];

    public $timestamps = false;

}
