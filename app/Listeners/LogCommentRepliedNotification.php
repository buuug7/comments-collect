<?php

namespace App\Listeners;

use App\Events\CommentReplied;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class LogCommentRepliedNotification
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
        Log::info($event->comment->targetUser);
    }
}
