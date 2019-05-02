<?php

namespace App\Http\Controllers;

use App\Setup;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class SetupController extends Controller
{
    public static function getSetting(string $name){
        if (!Cache::tags('setting')->has($name)){
            $data = Setup::where('title', '=', $name)->get();
            !$data->isEmpty() ? $data = $data->first()->value : $data = null;
            Cache::tags('setting')->put($name,$data,86400);
        }
        return Cache::tags('setting')->get($name) ?? null;
    }


    /**
     * 编辑网站配置操作
     */
    public function settingEditAction(Request $request)
    {
        //TODO 验证支付以及主题插件是否存在
//        $themes = ThemeController::getThemeArr();
//        $adminThemes = ThemeController::getAdminThemeArr();
//        $payPlugins = PayController::getPayPluginArr();
        $vaildateArr = [];
        foreach (SetupController::$settingArr as $item) {
            $vaildateArr[$item['title']] = $item['validate'];
        }

        $this->validate($request, $vaildateArr);


        foreach (SetupController::$settingArr as $key => $value) {
            if (Setup::where('title', $key)->first()->value == $request[$value['title']]) {
                continue;
            };

            if (Cache::has($key)){//清空缓存
                Cache::forget($key);
            };

            Setup::where('title', $key)->update(['value' => $request[$value['title']]]);
        }

        return redirect(route('admin.setting.index'))->with('status', 'success');
    }


    /**
     * 190114 V0.1.8 优化代码新增
     * 设置存储的配置Arr
     * @var array
     */
    public static $settingArr = [
        'setting.website.payment.wechat' => [
            'validate' => 'string|nullable',
            'title' => 'wechatplugin',
            'type' => 'diy'
        ],
        'setting.website.payment.alipay' => [
            'validate' => 'string|nullable',
            'title' => 'alipayplugin',
            'type' => 'diy'
        ],
        'setting.website.payment.qqpay' => [
            'validate' => 'string|nullable',
            'title' => 'qqpayplugin',
            'type' => 'diy'
        ],
        'setting.website.payment.diy' => [
            'validate' => 'string|nullable',
            'title' => 'diyplugin',
            'type' => 'diy'
        ],
        'setting.website.user.email.validate' => [
            'validate' => 'string|nullable',
            'title' => 'email_validate',
            'type' => 'select'
        ],
        'setting.mail.drive' => [
            'validate' => 'string|nullable',
            'title' => 'mailDrive',
            'type' => 'diy'
        ],
        'setting.website.spa.status' => [
            'validate' => 'string|nullable',
            'title' => 'spa',
            'type' => 'select'
        ],
        'setting.website.user.email.notice' => [
            'validate' => 'string|nullable',
            'title' => 'email_notice',
            'type' => 'select'
        ],
        'setting.website.admin.sales.notice' => [
            'validate' => 'string|nullable',
            'title' => 'sales_notice',
            'type' => 'select'
        ],
        'setting.website.admin.theme' => [
            'validate' => 'string|nullable',
            'title' => 'admintheme',
            'type' => 'diy'
        ],
        'setting.website.theme' => [
            'validate' => 'string|nullable',
            'title' => 'theme',
            'type' => 'diy'
        ],
        'setting.website.aff.status' => [
            'validate' => 'string|nullable',
            'title' => 'aff_status',
            'type' => 'select'
        ],
        'setting.website.title' => [
            'validate' => 'string|nullable|min:1|max:200',
            'title' => 'title',
            'type' => 'text'
        ],
        'setting.website.kf.url' => [
            'validate' => 'string|nullable|min:1|max:200',
            'title' => 'kfurl',
            'type' => 'text'
        ],
        'setting.website.privacy.policy' => [
            'validate' => 'string|nullable|min:1|max:200',
            'title' => 'privacy_policy',
            'type' => 'text'

        ],
        'setting.website.user.agreements' => [
            'validate' => 'string|nullable|min:1|max:200',
            'title' => 'user_agreements',
            'type' => 'text'
        ],
        'setting.website.subtitle' => [
            'validate' => 'string|nullable|min:1|max:200',
            'title' => 'subtitle',
            'type' => 'text'
        ],
        'setting.website.copyright' => [
            'validate' => 'string|nullable|min:1|max:200',
            'title' => 'copyright',
            'type' => 'text'
        ],
        'setting.website.currency.unit' => [
            'validate' => 'string|nullable|min:1|max:200',
            'title' => 'currencyunit',
            'type' => 'text'
        ],
        'setting.website.logo' => [
            'validate' => 'string|nullable|min:1|max:200',
            'title' => 'logo',
            'type' => 'text'
        ],
        'setting.website.logo.url' => [
            'validate' => 'string|nullable|min:1|max:200',
            'title' => 'logourl',
            'type' => 'text'
        ],
        'setting.wechat.service.status' => [
            'validate' => 'string|nullable',
            'title' => 'wechat_service',
            'type' => 'text'
        ],
        'setting.expire.terminate.host.data' => [
            'validate' => 'string|nullable',
            'title' => 'terminate_host_data',
            'type' => 'text'
        ],
        'setting.async.create.host' => [
            'validate' => 'string|nullable',
            'title' => 'async_create_host',
            'type' => 'text'
        ],
        'setting.website.index.keyword' => [
            'validate' => 'string|nullable|min:1|max:200',
            'title' => 'website_keyword',
            'type' => 'text'
        ],
    ];

}
