<?php

namespace App\Listeners;

use App\Events\PostStar;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\Environment\Console;

class PostStarListener
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
     * @param  PostStar  $event
     * @return void
     */
    public function handle(PostStar $event)
    {
        Log::info($event->post);
    }
}
