<?php

namespace App\Observers;

use App\Post;

class PostObserver
{
    public function deleting(Post $post)
    {
        $post->starUsers()->detach();
        $post->tags()->detach();
        $post->comments()->each(function ($comment) {
            $comment->delete();
        });
    }
}
