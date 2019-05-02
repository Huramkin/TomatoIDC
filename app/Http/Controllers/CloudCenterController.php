<?php

namespace App\Http\Controllers;

/**
 * 后期更新的云中心预留文件
 * 获取更新，检测版本号， 协助社区发展
 */

use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Yansongda\Pay\Log;


class CloudCenterController extends Controller
{
//    该功能未开发，该文件目前为无效文件

    //请求一次公告，缓存时间
    protected $cacheTime = "86400";

    /**
     * 公告更新服务器地址
     * 二开版本若要写自己的公告请在这里替换为自己的域名
     * @var array
     */
    protected $cloudCenterServerAddress=[
        //公告分发和更新服务器，如果担心隐私可屏蔽掉，屏蔽掉没公告/更新提醒，所有地址提供的服务一模一样
        //二次开发版本可设置为自己的公告服务器
        "ApiServer"=>[
            //国内接口
            "tidc.mercycloud.com",   //中国华南
            "tidc.rbq.org.cn",       //中国华北
            "tidc.yfsama.com",       //备用
            //国外接口
            "tidc.laji.dev",         //美国东部
            "tidc.qwq.one",          //美国中部
            "tidc.moe.beer",         //中国香港
            "tidc.rbq.ai",           //美国西部
            "tidc.dev",              //官方接口
            //第三方或官方合作或赞助的接口
            "tidc.futa.cloud",       //欧洲机房
            "tidc.quic.dev",         //备用，开发测试接口
        ],
        //以下接口非核心，删除不会影响原版核心功能
        //授权服务，开放给开发者用于鉴定授权的服务器接口
        "LicenseServer"=>[
            'tidc.license.wiki'
        ],
        //面板服务,开放给面板开发者的接口
        "PanelServer"=>[
            "tidc.panel.work",
            "tidc.sbbt.cc",
        ]
    ];

    /**
     *
     * @param $url string 需要发送Get请求的连接Api服务器的后缀
     * @param int $frequency 已连接测试次数
     * @return bool|\Psr\Http\Message\StreamInterface
     */
    protected function clientApiCenterGet($url, $frequency = 0)
    {
        $addressArr = shuffle($this->cloudCenterServerAddress['ApiServer']);
        if (!is_array($addressArr)){//反正出错
            Log::info("cloudCenterServerAddress error");
            return false;
        }
        $address = array_pop($addressArr);
        try {//尝试连接
            $client   = new Client(
                [
                    'base_uri' => "https://".$address,
                    'timeout'  => 5.0,
                ]
            );
            $response = $client->get($url);
        }
        catch (RequestException $e) {
            Log::info('Cloud center connect error', [$e, $url,$address]);
            if ($frequency >= count($this->cloudCenterServerAddress['ApiServer'])) {
                $frequency++;
                $this->clientApiCenterGet($url,$frequency);
            }
            return false;
        }
        return $response->getBody();
    }

    //获取最新版本
    public function getCloudVersion()
    {
        $result = json_decode($this->clientApiCenterGet('/version')) ?? false;
        if (!$result && $result->code != 0){
            Log::info("Get announcement result error");
            $result->data = "获取失败";
        }
        return $result->data;
    }

    //获取更新记录
    public function getCloudUpdateLog()
    {
        $result = json_decode($this->clientApiCenterGet('/version/update/log')) ?? false;
        if (!$result && $result->code != 0){
            Log::info("Get announcement result error");
            $result->data = "获取失败";
        }
        return $result->data;
    }

    //获取当前版本公告
    public function getCloudAnnouncement()
    {
        $result = json_decode($this->clientApiCenterGet('/version/announcement?version='.IndexController::$version)) ?? false;
        if (!$result && $result->code != 0){
            Log::info("Get announcement result error");
            $result->data = "获取失败";
        }
        return $result->data;
    }

    //缓存返回信息
    public function cacheResultData($name)
    {
//        if (!Cache::tags(['ApiServer'])->has($name)){
//            !$data->isEmpty() ? $data = $data->first()->value : $data = null;
//            Cache::tags('setting')->put($name,$data,86400);
//        }
//        return Cache::tags('setting')->get($name) ?? null;
    }

}
