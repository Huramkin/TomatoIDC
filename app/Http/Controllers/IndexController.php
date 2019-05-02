<?php

namespace App\Http\Controllers;

use App\GoodsCategories;
use App\Goods;
use App\Http\Controllers\Payment\PayController;
use App\Http\Resources\GoodCollection;
use App\Http\Resources\GoodsCategoriesResource;
use App\User;
use Illuminate\Http\Request;

/**
 * 返回首页以及不需要登陆验证的视图
 * Class IndexController
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{

    /**
     * 视图代码View
     */

    public static $version = "V0.2.0";//发布版本号

    /**
     * 返回重置密码表单
     */
    public function resetFormPage()
    {
        return view(ThemeController::backThemePath('auth.reset'));
    }

    /**
     * 返回首页视图
     */
    public function indexPage()
    {
        return view(ThemeController::backThemePath('index'));
    }

    /**
     * 获取商品
     * @return null
     */
    protected function getGoods()
    {
        $goods = Goods::where([
            ['status', '!=', '0'],
        ])
            ->join('goods_info','goods.id','=','goods_info.goods_id')
            ->orderBy('created_at', 'desc')
            ->get();
//        dd(123);
        !$goods->isEmpty() ?: $goods = null;
        return $goods;
    }

    /**
     * 商品列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function goodShowPage()
    {
        $goodsCategories = $this->getGoodsCategories();
        $goods = $this->getGoods();
        return view(ThemeController::backThemePath('show', 'home.goods'), compact('goods', 'goodsCategories'));
    }

    /**
     * 获取商品列表
     * @return GoodCollection|bool 成功JSON 失败返回null
     */
    public function getGoodListApi()
    {
        $goods = Goods::where([
            ['status', '!=', '0'],
            ['display', 1]
        ])->orderBy('level', 'desc')->get()->makeHidden([
            'created_at',
            'updated_at',
            'stock',
            'display',
            'configure_id',
            'server_id'
        ]);
        !$goods->isEmpty() ?: $goods = null;
        if ($goods) {
            return GoodCollection::make($goods);
        }
        return json_encode(['status' => 500]);
    }

    /**
     * 获取商品分类
     * @param $name string 商品分类名称
     * @return GoodsCategoriesResource|string 成功返回商品分类详细json 失败返回500 json
     */
    public function getGoodCategoriesApi($name)
    {
        $name = htmlspecialchars(trim($name));
        $categories = GoodsCategories::where([
            ['title', $name],
            ['status', '!=', '0'],
            ['display', 1]
        ])->get()->makeHidden([
            'created_at',
            'updated_at',
            'display',
        ]);;
        !$categories->isEmpty() ? $categories = $categories->first() : $categories = null;
        if ($categories) {
            return new GoodsCategoriesResource($categories);
        }
        return json_encode(['status' => 500]);
    }


    /**
     * 操作代码
     */

    /**
     * 获取商品分类
     * @return null
     */
    protected function getGoodsCategories()
    {
        $goods_categories = GoodsCategories::where([
            ['status', '=',1 ],
        ])->orderBy('created_at', 'desc')->get();
        !$goods_categories->isEmpty() ?: $goods_categories = null;
        return $goods_categories;
    }


    /**
     * 临时监控实现自动删除主机
     * TODO 以后版本会使用任务
     * 后续会废除
     * @return int
     */
    public function tempCronAction()
    {
        $hostController = new HostController();
        $payController = new PayController();
        $hosts = $hostController->autoCheckHostStatus();
        $hostController->autoTerminateHost();
        $order = $payController->autoCheckOrderStatus();
        $recharge = $payController->autoCheckRechargeStatus();
        $asyncCreateHost = $hostController->autoCheckAsyncCreateHost();
        return time();
    }


}
