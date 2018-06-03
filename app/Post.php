<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'contents',
        'reference',
        'user_id'
    ];

    protected $appends = [
        'comments_count',
        'has_star_by_request_user',
        'has_owned_by_request_user',
        'star_users_count',
    ];

    /**
     * the post created user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }


    /**
     * the star users of the post
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function starUsers()
    {
        return $this->belongsToMany(User::class, 'post_user_stars');
    }

    /**
     * the post owned tags
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

    /**
     * append attribute has_star_by_request_user
     * detect whether the post is star by request user
     * @return bool|mixed
     */
    public function getHasStarByRequestUserAttribute()
    {
        $authUser = Auth::guard('api')->check() ? Auth::guard('api')->user() : Auth::user();

        if (is_null($authUser)) {
            return false;
        }

        return $this->hasStarByGivenUser($authUser);
    }

    /**
     * append attribute has_owned_by_request_user
     * detect whether the post is owned by request user
     * @return bool
     */
    public function getHasOwnedByRequestUserAttribute()
    {
        $authUser = Auth::guard('api')->check() ? Auth::guard('api')->user() : Auth::user();

        if (is_null($authUser)) {
            return false;
        }

        return $this->hasOwnedByGivenUser($authUser);
    }

    /**
     * append attribute star_users_count
     * get the star users count
     * @return int
     */
    public function getStarUsersCountAttribute()
    {
        return $this->starUsers()->count();
    }

    /**
     * detect the post is star by a given user
     * @param User $user
     * @return mixed|boolean
     */
    public function hasStarByGivenUser(User $user)
    {
        $exists = self::whereHas('starUsers', function ($query) use ($user) {
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
