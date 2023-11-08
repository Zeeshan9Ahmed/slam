<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoggedInUser extends JsonResource
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
            'id' => $this->id,
            'full_name' => $this->full_name??"",
            'avatar' => $this->avatar??"",
            'email' => $this->email??"",
            'role' => $this->role??"",
            'phone_number' => $this->phone_number??"",
            'bio' => $this->bio??"",
            'is_social'=>$this->is_social?1:0,
            'profile_completed' => $this->profile_completed?1:0,
            'device_type' => $this->device_type??"",
            'device_token' => $this->device_token??"",
            'is_verified' => $this->email_verified_at?1:0,
            'skills' => $this->skills??"",
            'location' => $this->location??"",
            'social_links' => $this->social_links??"",
            'lat' => $this->lat??"",
            'lang' => $this->lang??"",
            'is_notification' => $this->notification_toggle
        ];
        
    }
}
