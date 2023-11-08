<?php

namespace App\Listeners;

use App\Events\ApproveEvent;
use App\Services\Notifications\CreateDBNotification;
use App\Services\Notifications\PushNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ApproveEventListener
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
     * @param  \App\Events\ApproveEvent  $event
     * @return void
     */
    public function handle(ApproveEvent $event)
    {
        $data = [
            'to_user_id'        =>  $event->user->id,
            'from_user_id'      =>  auth()->id(),
            'notification_type' =>  $event->type,
            
            'title' =>   $event->message,
        ];
        $data['redirection_id'] =  $event->event->id ;
        $data['description'] =  $event->message;
        $save_notification = app(CreateDBNotification::class)->execute($data);
        $send_push = app(PushNotificationService::class)->execute($data,[$event->user->device_token]);
    }
}
