<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use SoftDeletes;

    protected $table = 'bills';

    protected $fillable = ['time', 'unit', 'money', 'goods_id', 'content'];

    public function getGood()
    {
        return $this->hasOne('App\Goods', 'id', 'goods_id');
    }

    public function getUnitAttribute($value)
    {
        if (config('app.locale') == "zh-CN") {
            switch ($value) {
                case "day":
                    return "天";
                    break;
                case "month":
                    return "月";
                    break;
                case  "year":
                    return "年";
                    break;
            }
        }
      return $value;
    }

}
