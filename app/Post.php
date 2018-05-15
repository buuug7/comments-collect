<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'contents',
        'reference',
        'user_id'
    ];

    protected $appends = [
        'has_collected_by_request_user',
        'has_owned_by_request_user',
        'collected_users_count',
    ];

    /**
     * the post created user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * the post collected by users
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function collectedUsers()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * the post owned tags
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * append attribute [has_collected_by_request_user]
     * detect whether the post is collected by request user
     * @return bool|mixed
     */
    public function getHasCollectedByRequestUserAttribute()
    {
        if (Auth::check()) {
            return $this->hasCollectedByGivenUser(Auth::user());
        }
    }

    /**
     * append attribute [has_owned_by_request_user]
     * detect whether the post is owned by request user
     * @return bool
     */
    public function getHasOwnedByRequestUserAttribute()
    {
        if (Auth::check()) {
            return $this->hasOwnedByGivenUser(Auth::user());
        }
    }

    /**
     * append attribute [collected_users_count]
     * get the collected users count
     * @return int
     */
    public function getCollectedUsersCountAttribute()
    {
        return $this->collectedUsers()->count();
    }

    /**
     * detect the post is collected by a given user
     * @param User $user
     * @return mixed|boolean
     */
    public function hasCollectedByGivenUser(User $user)
    {
        $exists = self::whereHas('collectedUsers', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('post_id', $this->id);
        })->exists();
        return $exists;
    }

    /**
     * detect the post is owned by a given user
     * @param User $user
     * @return bool
     */
    public function hasOwnedByGivenUser(User $user)
    {
        return $user->id === $this->user_id;
    }

}
