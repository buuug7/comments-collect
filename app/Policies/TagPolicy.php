<?php

namespace App\Policies;

use App\User;
use App\Tag;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the tag.
     *
     * @param  \App\User $user
     * @param  \App\Tag $tag
     * @return mixed
     */
    public function view(User $user, Tag $tag)
    {
        //
    }

    /**
     * Determine whether the user can create tags.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the tag.
     *
     * @param  \App\User $user
     * @param  \App\Tag $tag
     * @return mixed
     */
    public function update(User $user, Tag $tag)
    {
        return $user->id === $tag->user_id;
    }

    /**
     * Determine whether the user can delete the tag.
     *
     * @param  \App\User $user
     * @param  \App\Tag $tag
     * @return mixed
     */
    public function delete(User $user, Tag $tag)
    {
        return $user->id === $tag->user_id;
    }
}
