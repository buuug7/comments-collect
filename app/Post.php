<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'contents', 'reference', 'user_id'
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

}
