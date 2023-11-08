<?php

namespace App\Listeners;

use App\Events\AcceptOrRejectFollowRequestEvent;
use App\Services\Notifications\CreateDBNotification;
use App\Services\Notifications\PushNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AcceptOrRejectFollowRequestListenere
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\AcceptOrRejectFollowRequest  $event
     * @return void
     */
    public function handle(AcceptOrRejectFollowRequestEvent $event)
    {

        $type = $event->type=="accept"?"APPROVED":"REJECTED";
        $data = [
            'to_user_id'        =>  $event->recipient->id,
            'from_user_id'      =>  auth()->id(),
            'notification_type' =>  'FOLLOW_'.$type,
            
            'title' =>   "your follow request has been ".$event->type."ed by ".auth()->user()->full_name,
        ];
        $data['redirection_id'] =   $event->recipient->id ;
        $data['description'] = "your follow request has been ".$event->type."ed by ".auth()->user()->full_name;
        $save_notification = app(CreateDBNotification::class)->execute($data);
        $send_push = app(PushNotificationService::class)->execute($data,[$event->recipient->device_token]);
    }
}
