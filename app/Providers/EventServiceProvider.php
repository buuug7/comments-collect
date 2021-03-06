<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\CommentReplied' => [
            'App\Listeners\CommentRepliedListener'
        ],
        'App\Events\PostCommented' => [
            'App\Listeners\PostCommentedListener'
        ],
        'App\Events\PostStar' => [
            'App\Listeners\PostStarListener'
        ],
    ];

    protected $subscribe = [
        'App\Listeners\UserEventSubscriber'
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
