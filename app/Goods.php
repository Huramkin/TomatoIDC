<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goods extends Model
{
    use SoftDeletes;

    protected $table = 'goods';

    protected $fillable = ['title','type'];


    public function info()
    {
        return $this->hasOne('App\GoodInfoModel','id','goods_id');
    }

    /**
     * 获取此商品所属分组
     */
    public function goodsCategories()
    {
        return $this->hasOne('App\GoodsCategories', 'id', 'categories_id');
    }

    /**
     * 获取此商品所属分组
     */
    public function goodsConfigure()
    {
        return $this->belongsTo('App\GoodsConfigure', 'id', 'configure_id');
    }

    /**
     * 获取此商品所属分组
     */
    public function server()
    {
        return $this->hasOne('App\Server', 'id', 'server_id');
    }

    public function order()
    {
        return $this->hasMany('App\Order','goods_id','id');
    }

    /**
     * 获取计费
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bill()
    {
        return $this->hasMany('App\Bill','goods_id','id');
    }


    /**
     * 商品类别修改器
     * @param $value
     * @return string
     */
    public function getCategoriesIdAttribute($value)
    {
        if (empty($value)) {
            return '未分组';
        }
        else {
            return GoodsCategories::find($value)->title;
        }
    }
}
