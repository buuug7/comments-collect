<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        'contents',
        'post_id',
        'user_id',
        'target_user_id',
        'target_comment_id'
    ];

    protected $appends = [
        'like_count'
    ];

    /**
     * return the comment created user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * return the comment under which post
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
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


    public function getLikeCountAttribute()
    {
        return $this->likedUsers()->count();
    }


}
