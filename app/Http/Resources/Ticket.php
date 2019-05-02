<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Ticket extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'status' => 1,
            'msg'=>'Success',
            'data' => [
                'title'=> $this->title,
                'content'=>$this->content,
                'reply'=>TicketReplyCollection::collection($this->whenLoaded('ticket')),
            ]
        ];
    }
}
