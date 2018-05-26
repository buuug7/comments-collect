<?php

namespace App\Events;

use App\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommentReplied
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;
    public $repliedComment;

    /**
     * Create a new event instance.
     * @param Comment $comment
     * @param Comment $repliedComment
     * @return void
     */
    public function __construct(Comment $comment, Comment $repliedComment)
    {
        $this->comment = $comment;
        $this->repliedComment = $repliedComment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }


}