<?php

namespace App\Listeners;

use App\Notifications\UserLogin;
use App\Notifications\UserLoginNotify;
use Illuminate\Support\Facades\Log;

class UserEventSubscriber
{
    public function onUserLogin($event)
    {
        $event->user->notify((new UserLoginNotify($event->user)));
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