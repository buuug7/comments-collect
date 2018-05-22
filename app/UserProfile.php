<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id','avatar_url','website','bio'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
