<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Comment extends Model
{

    protected $fillable = [
        'contents',
        'commentable_id',
        'commentable_type',
        'user_id',
        'target_user_id',
        'target_comment_id'
    ];

    protected $appends = [
        'like_count',
        'has_liked_by_request_user',
        'has_owned_by_request_user'
    ];

    /**
     * return the comment created user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function commentable()
    {
        return $this->morphTo();
    }


    /**
     * get the target user of this comment
     * return null if the comment is not reply other comment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    /**
     * get the target comment
     * return null if the comment is not reply other comment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function targetComment()
    {
        return $this->belongsTo(Comment::class, 'target_comment_id');
    }

    /**
     * return the comments of reply this comment
     * return null if the comment is not reply other comment
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function repliedComments()
    {
        return $this->hasMany(Comment::class, 'target_comment_id');
    }


    /**
     * return the users of liked this comment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likedUsers()
    {
        return $this->belongsToMany(User::class, 'comment_user_likes');
    }


    /**
     * append attribute like_count
     * get the liked user count
     * @return int
     */
    public function getLikeCountAttribute()
    {
        return $this->likedUsers()->count();
    }

    /**
     * append attribute has_liked_by_request_user
     * detect the comment is liked by request user
     * @return bool
     */
    public function getHasLikedByRequestUserAttribute()
    {
        $authUser = Auth::guard('api')->check() ? Auth::guard('api')->user() : Auth::user();

        if (is_null($authUser)) {
            return false;
        }

        return $this->hasLikedByGivenUser($authUser);
    }

    /**
     * append attribute has_owned_by_request_user
     * detect the comment is owned by request user
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
     * detect the comment is liked by given user
     * @param User $user
     * @return bool
     */
    public function hasLikedByGivenUser(User $user)
    {
        $exists = self::whereHas('likedUsers', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('comment_id', $this->id);
        })->exists();
        return $exists;
    }


    /**
     * detect the comment is owned by given user
     * @param User $user
     * @return bool
     */
    public function hasOwnedByGivenUser(User $user)
    {
        return $this->user_id === $user->id;
    }


}
