<?php

namespace App\Observers;

use App\Post;

class PostObserver
{
    public function deleting(Post $post)
    {
        $post->staredUsers()->detach();
    }
}
