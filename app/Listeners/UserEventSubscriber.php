<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;

class UserEventSubscriber
{
    public function onUserLogin($event)
    {
        Log::info("User Login: {$event->user->name}");
    }

    public function onUserLogout($event)
    {
        Log::info("User Logout: {$event->user->name}");
    }

    public function subscribe($event)
    {
        $event->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );

        $event->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@onUserLogout'
        );
    }
}