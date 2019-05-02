<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminGoodsPost extends FormRequest
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
            'title' => 'string|min:3|max:200',
            'subtitle' => 'string|min:3|max:200|nullable',
            'description' => 'string|min:3|nullable',
            'display' => 'boolean',
            'level' => 'integer',
            'configure' => 'nullable|exists:goods_configure,id',
            'server' => 'nullable|exists:servers,id|nullable',
            'categories' => 'nullable|exists:goods_categories,id',
            'purchase_limit' => 'nullable|integer',
            'inventory' => 'nullable|integer',
            'domain_config' => 'nullable|integer',
            'id' => 'sometimes|exists:goods,id|required',
            //sometimes
        ];
    }
}
