<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    protected $appends = [
        'avatar_url'
    ];

    /**
     * user profile
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }


    /**
     * append attribute [avatar_url]
     * return the user avatar url
     * @return mixed
     */
    public function getAvatarUrlAttribute()
    {
        return $this->getAvatar();
    }

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
     * user star posts
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function starPosts()
    {
        return $this->belongsToMany(Post::class, 'post_user_stars');
    }


    /**
     * return the user avatar url
     * @return mixed
     */
    public function getAvatar()
    {
        if ($this->profile->avatar_url) {
            return Storage::url($this->profile->avatar_url);
        }
        return '/images/default-avatar.png';
    }

}
