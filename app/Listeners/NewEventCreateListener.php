<?php

namespace App\Listeners;

use App\Events\NewEventCreateEvent;
use App\Models\User;
use App\Services\Notifications\CreateDBNotification;
use App\Services\Notifications\PushNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewEventCreateListener
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
     * @param  \App\Events\NewEventCreateEvent  $event
     * @return void
     */
    public function handle(NewEventCreateEvent $event)
    {
        $data = [
            'to_user_id'        =>  0,
            'from_user_id'      =>  auth()->id(),
            'notification_type' =>  'NEW_EVENT',
            'title' => $event->message,
            // 'data' => ['user_id' => auth()->id() , 'full_name' => auth()->user()->full_name , 'avatar' => auth()->user()->avatar],
        ];
        //Generate Notifications For Guests / Users
        $data['redirection_id'] =  $event->event_id;
        $data['description'] =  $event->message ;
        $guests = User::where(['role' => 'user'])->where('device_token', '!=', Null)->where('notification_toggle', 1)->get();//->pluck('device_token')->toArray();
        foreach ($guests as $guest){

            $data['to_user_id'] = $guest->id;
            $save_notification = app(CreateDBNotification::class)->execute($data);
        }
        $guests_tokens = $guests->pluck('device_token')->toArray();
        if ($event->author['is_notification_on'] == 1){
            //Generate Notification For Author  
            $data['to_user_id'] = $event->author['author_id'];
            $save_notification = app(CreateDBNotification::class)->execute($data);
    
            //Send Notification To Author And Guest For Event
            $guests_tokens[] = $event->author['device_token'];
        }
        $send_push = app(PushNotificationService::class)->execute($data,$guests_tokens);
    }
}
