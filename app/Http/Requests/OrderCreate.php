<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderCreate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'goods_id' => 'numeric|nullable|exists:goods,id',
            'type' => 'string|required|in:goods,recharge',
            'coupon'=>'string|nullable|exists:coupon,key',
            'price'=>'numeric|nullable',
            'payment' => 'in:wechat,alipay,diy,qqpay,account|string',
        ];
    }

    public function messages()
    {
        return [
            'coupon.exists' => '请输入正确的折扣代码',
            'type.in' => '下单错误'
        ];
    }
}
