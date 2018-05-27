<?php

namespace App\Listeners;

use App\Events\CommentReplied;
use App\Notifications\CommentRepliedNotify;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentRepliedListener
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
     * @param  CommentReplied $event
     * @return void
     */
    public function handle(CommentReplied $event)
    {
        // send a comment replied notification
        User::find($event->comment->user_id)
            ->notify((new CommentRepliedNotify($event->comment, $event->repliedComment)));
    }
}
