<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Goods extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
//        dd($this->goodsCategories);
        return [
            'status' => 1,
            'msg' => 'Success',
            'dara' => [
                'id' => $this->id,
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'description' => $this->description,
                'price' => $this->price,
                'type' => $this->type,
                'bill'=>BillCollection::collection($this->whenLoaded('bill')),
                'categories'=>Goodscategories::collection($this->whenLoaded('goodsCategories')),
                'level'=>$this->level,
                'status'=>$this->status,
                'purchase_limit'=>$this->purchase_limit,
                'upgrade'=>$this->upgrade,
                'stock'=>$this->stock
            ]
        ];
    }
}
