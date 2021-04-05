<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivitiyResource extends JsonResource
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
            'id' => $this->id,
            'email' => [
                'id' => $this->email->id,
                'sender' => $this->email->sender,
                'recipient' => $this->email->recipient,
                'subject' => $this->email->subject,
            ],
            'status' => config("minisend.statuses.{$this->status}"),
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
