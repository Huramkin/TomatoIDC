<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['check.install.status', 'throttle:60,1'])->group(function () {//安装路由
    //Install
    Route::get('install/init', 'InstallController@installPage'); //Install View
    Route::post('install/init', 'InstallController@installAction');//Install Action
});


Route::middleware(['throttle:60,1','check.install.status'])->group(function () {
    Route::get('/', function (){
        return 'Hello TIDC';
    });//首页视图
    //Goods Show Page
    Route::get('goods/show', 'IndexController@goodShowPage')->name('good.show');//商品列表Goods Show Page
    //User email　validate
    Route::get('page/{hash}','DiyPageController@indexPage')->name('diy_page');
});

Auth::Routes();

// wecaht/order/notify /alipay/order/notify /diy/order/notify
Route::any('/{payment}/order/notify', 'Payment\PayController@notify');//支付回调
Route::get('/temp/cron', "IndexController@tempCronAction");//临时监控

Route::prefix('admin')->group(function () {//管理路由
    Route::middleware(['auth', 'check.admin.authority', 'throttle:60,1'])->group(function () {
        Route::name('admin.')->group(function () {

            Route::get('/', 'AdminController@indexPage')->name('home');//Home Index View

            Route::prefix('api/v1')->group(function (){
                Route::get('goods/list','Api\AdminController@goodsListApi');
                Route::get('index','Api\AdminController@indexDataApi');
            });

            Route::prefix('user')->group(function () { //User Setting
                //Show
                Route::get('show', 'AdminController@userShowPage')->name('user.show');
                //Add
                Route::get('add', 'AdminController@userEditPage');
                Route::post('add', 'AdminController@userEditPage');
                //Edit
                Route::get('edit/{id}', 'AdminController@userEditPage')->name('user.edit');
                Route::post('edit', 'UserController@userEditAction');
            });

            Route::prefix('order')->group(function () { //订单 Order
                Route::get('show', 'AdminController@orderShowPage')->name('order.show');
                Route::get('edit/{no}', 'AdminController@orderEditPage')->name('order.edit');
                Route::post('edit', 'OrderController@orderEditAction');
            });
            Route::prefix('host')->group(function () { //主机 Host
                //Show
                Route::get('show', 'AdminController@hostShowPage')->name('host.show');
                //Recreate host action
                Route::post('create/host/re', 'HostController@reCreateHost')->where(['id' => '^[0-9]*$']);
                //Host Edit
                Route::get('detailed/{id}','AdminController@hostDetailedPage')->where(['id' => '^[0-9]*$'])->name('host.detailed');
                Route::post('detailed','HostController@hostEditAction');
                //host manager
                Route::post('open','HostController@openHost')->name('host.open');
                Route::post('close','HostController@closeHost')->name('host.close');
                Route::post('terminate','HostController@terminateHost')->name('host.terminate');
            });
            Route::prefix('work/order')->group(function () { //工单 Work order
                //show
                Route::get('show', 'AdminController@workOrderShowPage')->name('work.order.show');
                //Work order dateiled
                Route::get('detailed/{id}', 'AdminController@workOrderDetailedPage')->name('work.order.detailed')->where(['id' => '^[0-9]*$']);
                //Work order close
                Route::post('close', 'WorkOrderController@workOrderCloseAction')->name('work.order.close');
                //Work order reply
                Route::post('reply', 'WorkOrderController@workOrderAdminReplyAction')->name('work.order.reply');
            });
            Route::prefix('new')->group(function () { //新闻 news
                //show
                Route::get('show', 'AdminController@newShowPage')->name('new.show');
                //add
                Route::get('add', 'AdminController@newAddPage')->name('new.add');
                Route::post('add', 'NewController@newAddAction');
                //edit
                Route::get('edit/{id}', 'AdminController@newEditAction')->name('new.edit');
                Route::post('edit', 'NewController@newEditAction');
                //del
                Route::post('del', 'NewController@newDelAction')->name('new.del');
            });
            Route::prefix('goods')->group(function () { //商品
                //Goods categories list
                Route::get('show', 'AdminController@goodShowPage')->name('good.show');
                //Goods categories add
                Route::get('categories/add', 'AdminController@goodCategoriesAddPage')->name('good.categories.add');
                Route::post('categories/add', 'GoodsController@goodCategoriesAddAction');
                //Goods categories edit
                Route::get('categories/edit/{id}', 'AdminController@goodCategoriesEditPage')->name('good.categories.edit')->where(['id' => '^[0-9]*$']);
                Route::post('categories/edit', 'GoodsController@goodCategoriesEditAction');
                //Goods categories del
                Route::post('categories/del', 'GoodsController@goodCategoriesDelAction')->name('good.categories.del');
                //Goods configure add
                Route::get('configure/add/{type}', 'AdminController@goodConfigureAddPage')->name('good.configure.add');
                Route::post('configure/add', 'GoodsConfigureController@goodConfigureAddAction');
                //Goods configure del
                Route::post('configure/del', 'GoodsConfigureController@goodConfigureDelAction')->name('good.configure.del');
                //Goods configure edit
                Route::get('configure/edit/{id}', 'AdminController@goodConfigureEditPage')->name('good.configure.edit')->where(['id' => '^[0-9]*$']);
                Route::post('configure/edit', 'GoodsConfigureController@goodConfigureEditAction');
                //Goods add
                Route::get('add', 'AdminController@goodAddPage')->name('good.add');
                Route::post('add', 'GoodsController@goodAddAction');
                //Goods Edit
                Route::get('edit/{id}', 'AdminController@goodEditPage')->name('good.edit');
                Route::get('edit', 'AdminController@userEditPage');
                Route::post('edit', 'GoodsController@goodEditAction');

                Route::get('charging/{id}','AdminController@goodChargingPage')->name('good.charging');
                Route::post('charging/edit','GoodsController@goodChargingEdit')->name('good.charging.edit');
                Route::post('charging/add','GoodsController@goodChargingAdd')->name('good.charging.add');
                Route::post('charging/del','GoodsController@goodChargingDel')->name('good.charging.del');
                //Goods Del
                Route::post('del', 'GoodsController@goodDelAction')->name('good.del');
            });

            Route::prefix('setting')->group(function () { //全局设置
                Route::get('/', 'AdminController@settingIndexPage')->name('setting.index');
                Route::post('/', 'SetupController@settingEditAction');
                //Payment Setting
                Route::get('{payment}/pay/config', 'AdminController@paymentPluginConfigPage')->name('setting.pay');
                Route::post('pay/config', 'Payment\PayController@paymentPluginConfigAction');
                //Mail Setting
                Route::get('mail/config','AdminController@mailDriveConfigPage')->name('setting.mail');
                Route::post('mail/config','MailDrive\UserMailController@mailDriveConfigAction');
                //Wechat Setting
                Route::get('wechat/config','AdminController@wechatConfigPage')->name('setting.wechat');
                Route::post('wechat/config','Wechat\WechatController@wechatConfigAction');
            });
            Route::prefix('server')->group(function () { //服务器设置
                //Show
                Route::get('show', 'AdminController@serverShowPage')->name('server.show');
                //Status
                Route::get('status/{id}', 'ServerController@serverStatusPage')->name('server.status')->where(['id' => '^[0-9]*$']);
                //Add
                Route::get('add', 'AdminController@serverAddPage')->name('server.add');
                Route::post('add', 'ServerController@serverAddAction');
                //Edit
                Route::get('edit/{id}', 'AdminController@serverEditPage')->name('server.edit')->where(['id' => '^[0-9]*$']);
                Route::post('edit', 'ServerController@serverEditAction');
                //Del
                Route::post('del', 'ServerController@serverDelAction')->name('server.del');
            });
            Route::prefix('prepaid/key')->group(function () { //充值Key管理
                //Show
                Route::get('show','AdminController@prepaidKeyShowPage')->name('prepaid.key.show');
                //Add
                Route::get('add','AdminController@prepaidKeyAddPage')->name('prepaid.key.add');
                Route::post('add','PrepaidKeyController@addKeyAction');
            });
            Route::prefix('diy/page')->group(function(){ //自定义页面 管理
                //show
                Route::get('show', 'AdminController@diyPageShowPage')->name('diy.page.show');
                //add
                Route::get('add', 'AdminController@diyPageAddPage')->name('diy.page.add');
                Route::post('add', 'DiyPageController@diyPageAddAction');
                //edit
                Route::get('edit/{hash}', 'AdminController@diyPageEditAction')->name('diy.page.edit');
                Route::post('edit', 'DiyPageController@diyPageEditAction');
                //del
                Route::post('del', 'DiyPageController@diyPageDelAction')->name('diy.page.del');
            });
        });

    });
});

//Route::post('logout', 'Auth\LoginController@logout')->name('logout');//登出操作 Logout Action
Route::get('home',function (){
   return "welcome";
});

//V0.2移除全部直接返回，改用API

//Route::prefix('home')->group(function () {//首页路由
//    Route::middleware(['auth', 'throttle:60,1'])->group(function () {
//        //Logout
//        Route::post('logout', 'Auth\LoginController@logout')->name('logout');//登出操作 Logout Action
//        //Home
//        Route::get('/', 'HomeController@indexPage')->name('home');//用户中心视图
//        //User profile
//        Route::get('user/profile', 'HomeController@userProfilePage')->name('user.profile');//个人信息视图
//        Route::post('user/profile', 'UserController@userProfileAction');//个人信息操作
//        //User Email Vaildate
//        Route::get('email/validate','HomeController@userEmailValidatePage')->name('user.email.validate');
//        //Goods Buy & pay
//        Route::get('buy/{id}', 'HomeController@goodsBuyPage')->name('good.buy');//个人信息视图
//        Route::get('pay/{no}', 'HomeController@rePayOrderPage')->name('order.pay.no')->where(['no' => '^[0-9]*$']);//订单未支付再次支付
//        Route::get('renew/{id}', 'HomeController@renewHostPage')->name('host.renew')->where(['id' => '^[0-9]*$']);//续费主机 //renew view
//        Route::post('renew/host', 'OrderController@renewHostAction')->name('host.renew.action');//续费主机 //renew action
//        Route::post('pay/re', 'OrderController@rePayOrderAction')->name('order.pay.re');//再次支付 //repay action
//        //Work Order
//        Route::get('workorder/show', 'HomeController@workOrderShowPage')->name('work.order.show');//工单列表
//        Route::get('workorder/add', 'HomeController@workOrderAddPage')->name('work.order.add');//工单添加
//        Route::post('workorder/add', 'WorkOrderController@workOrderAddAction')->name('work.order.add');//工单添加
//        //Host
//        Route::get('host/show', 'HomeController@hostShowPage')->name('host.show');//host list view
//        Route::post('host/reset/pass', 'HostController@resetPassHost')->name('host.pass.reset');//host reset password
//        Route::get('host/detailed/{id}', 'HomeController@hostDetailedPage')->name('host.detailed');//host detailed view
//
//        Route::post('host/panel/login','HostController@managePanelLogin')->where(['id' => '^[0-9]*$'])->name('host.panel.login');        //manager panel login action
//        //News
//        Route::get('new/show', 'HomeController@newShowPage')->name('new.show');//新闻列表 news list view
//        Route::get('new/{id}', 'HomeController@newPostPage')->name('new.post')->where(['id' => '^[0-9]*$']);//news detailed view
//        //Order
//        Route::get('order/show', 'HomeController@orderShowPage')->name('order.show');//新闻列表
//        Route::post('order/create', 'OrderController@orderCreateAction')->name('order.create');//消息列表
//        Route::get('order/detailed/{id}', 'HomeController@orderDetailedPage')->name('order.detailed')->where(['no' => '^[0-9]*$']); //Order detailed View
//        Route::any('order/status', 'OrderController@orderCheckStatusAction')->name('order.status');//订单状态
//        //Work order
//        Route::get('work/order/detailed/{id}', 'HomeController@workOrderDetailedPage')->name('work.order.detailed')->where(['id' => '^[0-9]*$']);//Work detailed View
//        Route::post('reply', 'WorkOrderController@workOrderReplyAction')->name('work.order.reply');//工单回复 Work reply action
//        //User recharge
//        Route::get('user/recharge','HomeController@userRechargePage')->name('user.recharge');//用户充值 //user recharge view
//        Route::post('user/recharge/pay','UserRechargeController@userRechargePayAction')->name('user.recharge.pay');//用户操作 //user pay action
//        Route::any('user/recharge/status','UserRechargeController@userRechargeCheckStatusAction')->name('user.recharge.status'); //User recharge status check action
//        Route::post('user/recharge/prepaid/key','PrepaidKeyController@rechargePrepaidKeyAction')->name('prepaid.key');//卡米充值 Key recharge action
////diy Page
////        Route::get('diy/page/temp/{hash?}{code?}','DiyPageController@diyPageTempPage')->name('diy.page.temp');
//    });
//});


//Route::middleware(['auth','throttle:3,1'])->group(function () {
//    Route::post('home/email/validate/action','UserController@userEmailValidateSendAction')->name('user.email.validate.action');
//
//});
//Route::get('home/email/validate/action/test','UserController@userEmailValidateSendAction');
