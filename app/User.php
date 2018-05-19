<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * user created posts
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * user created comments
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    /**
     * get all of replied comments posted by the user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function byRepliedComments()
    {
        return $this->hasMany(Comment::class, 'target_user_id');
    }

    /**
     * return the comments of user liked (thumbs up)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likedComments()
    {
        return $this->belongsToMany(Comment::class, 'comment_user_likes');
    }


    /**
     * user stared posts
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function staredPosts()
    {
        return $this->belongsToMany(Post::class, 'post_user_stars');
    }

}
