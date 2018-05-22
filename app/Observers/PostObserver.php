<?php

namespace App\Observers;

use App\Post;

class PostObserver
{
    public function deleting(Post $post)
    {
        $post->staredUsers()->detach();
        $post->tags()->detach();
        $post->comments()->each(function ($comment) {
            $comment->delete();
        });
    }
}
