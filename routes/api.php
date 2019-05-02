<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('/v1')->group(function () {
    Route::middleware(['throttle:60,1'])->group(function () {
        Route::get('goods/list', 'IndexController@getGoodListApi');//获取商品列表
        Route::get('goods/categories/{name}', 'IndexController@getGoodCategoriesApi');//查询商品分类信息
        Route::post('user/login', 'IndexController@apiLoginAction');
        Route::middleware(['auth', 'check.admin.authority'])->group(function () {
            Route::prefix('')->group(function () {

            });
        });
    });
});


Route::prefix('/v1/orders/')->group(function () {
    Route::middleware('auth:api')->group(function (){
        Route::get('search', 'Api/OrderController@search');//搜索
        Route::get('list', 'Api/OrderController@list');//列表
        Route::post('create', 'Api/OrderController@create');//下单
        Route::post('renew','Api/OrderController@create');//续费订单/....（通用接口）
    });
});

Route::prefix('/v1/pay/')->group(function () {
    Route::get('search', 'Api/PayController@search');//搜索
    Route::get('list', 'Api/PayController@list');//列表
    Route::post('pay', 'Api/PayController@pay');//生成支付
});

Route::prefix('/v1/goods/')->group(function () {
    Route::get('search', 'Api/PayController@search');//搜索
    Route::get('show', 'Api\GoodsController@show');//商品列表
});

Route::prefix('/v1/hosts/')->group(function () {
    Route::get('search', 'Api/HostController@search');//搜索
    Route::get('list', 'Api/HostController@list');//列表
    Route::post('update', 'Api/HostController@pay');//更新配置
    Route::post('renew', 'Api/HostController@renew');//续费服务器
});

Route::prefix('/v1/users/')->group(function (){
    Route::post('profile','Api/UserController@profile');//个人详细信息
    Route::post('update','Api/UserController@update');//更新
    Route::post('recharge','Api/UserController@recharge');//用户充值
});

Route::prefix('/v1/tickets/')->group(function (){//工单
    Route::middleware('auth:api')->group(function (){
        Route::get('show','Api\TicketController@show');//工单列表
        Route::get('detail/{ticket}','Api\TicketController@detail')->middleware('can:view,ticket');//工单列表
        Route::post('create','Api\TicketController@create');//工单创建
        Route::post('reply/{ticket}','Api\TicketController@reply')->middleware('can:update,ticket');//工单回复
    });
});
