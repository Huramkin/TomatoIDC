<?php

namespace App\Http\Controllers\Api;

use App\Goods;
use App\Http\Controllers\ApiController;
use App\Http\Resources\AdminGoods;
use App\Http\Resources\AdminIndexCollection;
use App\Server;


/**
 *  * 管理页面以及全局设置页面及操作
 * TODO 清理代码结构
 * Class AdminController
 * @package App\Http\Controllers
 */
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.admin.authority');
    }


    public function goodsListApi()
    {
        $goods = Goods::where([
            ['status', '!=', '0']
        ])
            ->join('goods_info','goods.id','=','goods_info.goods_id')
            ->get();
        !$goods->isEmpty() ?: $goods = null;
        if ($goods){
            return new AdminGoods($goods);
        }
        return ApiController::makeApiMsg(0,"goods is null",'');

    }

    public function indexDataApi()
    {
        $server = Server::all();
        return new AdminIndexCollection($server);
    }
}
