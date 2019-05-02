<?php

namespace App\Providers;

use App\Http\Controllers\SetupController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Setup;
use Laravel\Telescope\TelescopeServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * 获取需要给模版传递的参数
     * 配置项名称 => 传递后变量名
     */
    protected $getSetting = [
        'setting.website.title'=>'websiteName',
        'setting.website.copyright'=>'copyright',
        'setting.website.payment.qqpay'=>'paymentQqpay',
        'setting.website.payment.wechat'=>'paymentWechat',
        'setting.website.payment.alipay'=>'paymentAlipay',
        'setting.website.url'=>'websiteUrl',
        'setting.website.logo'=>'websiteLogo',
        'setting.website.subtitle'=>'websiteSubtitle',
        'setting.website.currency.unit'=>'currencyUnit',
        'setting.website.kf.url'=>'websiteKfUrl',
        'setting.website.logo.url'=>'websiteLogoUrl',
        'setting.website.privacy.policy'=>'privacyPolicy',
        'setting.website.user.agreements'=>'userAgreements',
        'setting.website.index.keyword'=>'keywords',
        'setting.website.user.register.email.validate'=>"userRegisterEmailValidate",
    ];

    protected  function viewVariable()
    {
        if (!empty(config('database.connections.mysql.database'))) { //数据表未设置
            if (Schema::hasTable('setups'))//当数据表存在才返回
            {
                foreach ($this->getSetting as $key => $value) {
                    View::share($value, SetupController::getSetting($key));
                }
            } else {
                return null;
            }
        }
    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $this->viewVariable();//向视图传递变量
        if ($this->app->isLocal()) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }
}
