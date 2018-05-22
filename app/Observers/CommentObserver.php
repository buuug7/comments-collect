<?php

namespace App\Observers;

use App\Comment;

class CommentObserver
{
    public function deleting(Comment $comment)
    {
        $comment->likedUsers()->detach();
        $comment->repliedComments()->update([
            'target_comment_id' => null,
            'target_user_id' => null,
        ]);
    }
}