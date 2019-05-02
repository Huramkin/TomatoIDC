<?php

namespace App\Http\Controllers\Payment;

/**
 * TrimePay支付
 */

use App\Http\Controllers\Controller;
use App\Order;
use App\Setup;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Overtrue\LaravelYouzan\Youzan;

class TrimePayController extends Controller
{
    public $pluginName = "TrimePay支付";
    public $pluginType=true;
    //获取数据库设置
    protected function getSetting()
    {
        foreach ($this->settingArray as $key => $value) {
            $setTemp = Setup::where('name', $key)->get();
            if ($setTemp->isEmpty()) {
                Setup::create([
                    'name' => $key,
                    'value' => $value
                ]);
            }
        }
        $result = [];
        foreach ($this->settingArray as $key => $value) {
            $setTemp = Setup::where('name', $key)->first();
            $result[$key] = $setTemp['value'];
        }
        return $result;
    }

    //配置名称
    protected $settingArray = [
        'setting.website.payment.trimepay.appid' => null,
        'setting.website.payment.trimepay.app.secret' => null,
    ];

    /**
     * 返回插件设计项
     * @param $payment
     * @return array
     */
    public function pluginConfigInputForm($payment)
    {
        $this->getSetting();//防止插件未初始化
        return [
            'AppId' => 'setting.website.payment.trimepay.appid',
            'AppSecret' => 'setting.website.payment.trimepay.app.secret',
        ];
    }

    /**
     * 回调
     * @param $request
     * @param $payment
     * @return bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public function notify($request, $payment)
    {
        $this->validate($request,[
            'payStatus' => "string|required",
            'payFee' => "integer|required",
            'callbackTradeNo' => "string",
            'merchantTradeNo' => "string|exists:orders,no|required",
            'payType' => "string",
            'sign' => "string|required",
        ]);

        if (Order::where("no",$request['merchantTradeNo'])->first()->api_no == $request['sign']) {
            echo "SUCCESS";
            return $request['merchantTradeNo'];
        }
    }

    //生成支付URL
    public function Pay($order, $payment)
    {

        $setting = $this->getSetting();
        $payType = "ALIPAY_WEB";
        $data = [
          "appId"=>$setting['setting.website.payment.trimepay.appid'],
            "merchantTradeNo"=>$order->no,
            "totalFee"=>$order->price * 100,
            "notifyUrl"=>route("host.show"),
            "returnUrl"=>url("/{$payment}/order/notify"),
            "payType"=>$payType,
        ];
        ksort($data);
        $parameter = http_build_query($data);
        $signature = strtolower(md5(md5($parameter).$setting['setting.website.payment.trimepay.app.secret']));

        $data['sign'] = $signature;

        Order::where("no",$order->no)->update(['api_no'=>$signature]);//记录签名
        try {
            $client = new Client();
            $resp = $client->request('POST', "https://api.trimepay.com/gateway/pay/go", [
                "form_params"=>$data
            ]);
        } catch (RequestException $e) {
            Log::error('TrimePay create pay error ', [$e, $data]);
            return ['type' => 'qrcode_string', 'url' => "Error Place Check Setting"];
        }
        $result = json_decode($resp->getBody()->getContents());
        if ($result->code == 0){
            return ['type' => 'redirect', 'url' => $result->data];
        }

        Log::error('TrimePay create pay error ', [$result, $data]);
        return ['type' => 'qrcode_string', 'url' => "Error Place Check Setting"];//错误返回
    }

}
