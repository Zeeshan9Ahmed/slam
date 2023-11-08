<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id??"",
            'title' => $this->title??"",
            'location' => $this->location,
            'detail' => $this->detail,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'event_status' => $this->user_status==null?"":$this->user_status->interested,
            'is_bookmarked' => $this->is_bookmarked,
            'event_capacity' => $this->event_capacity,
            'created_at' => $this->created_at,
            'image' => ImageResourece::collection($this->whenLoaded('images')),
            'venue' => $this->venue,
           'artist' => EventUserResource::collection($this->whenLoaded('artists')),
           'attendess' => EventUserResource::collection($this->whenLoaded('attendess')),
// 
            
        ];
    }
}
