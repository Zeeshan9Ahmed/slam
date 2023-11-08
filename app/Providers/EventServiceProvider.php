<?php

namespace App\Providers;

use App\Events\AcceptOrRejectFollowRequestEvent;
use App\Events\ApproveEvent;
use App\Events\FollowUserEvent;
use App\Events\NewEventCreateEvent;
use App\Listeners\AcceptOrRejectFollowRequestListenere;
use App\Listeners\ApproveEventListener;
use App\Listeners\FollowUserListener;
use App\Listeners\NewEventCreateListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        FollowUserEvent::class => [
            FollowUserListener::class
        ], 
        NewEventCreateEvent::class => [
            NewEventCreateListener::class
        ],
        ApproveEvent::class => [
            ApproveEventListener::class
        ],
        AcceptOrRejectFollowRequestEvent::class => [
            AcceptOrRejectFollowRequestListenere::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
