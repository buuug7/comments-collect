<?php

namespace App\Listeners;

use App\Events\PostCommented;
use App\Notifications\PostCommentedNotify;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostCommentedListener
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
     * @param  PostCommented  $event
     * @return void
     */
    public function handle(PostCommented $event)
    {
        // send a post comment notification (database notifications)
        User::find($event->post->user_id)
            ->notify((new PostCommentedNotify($event->post,$event->comment)));
    }
}
