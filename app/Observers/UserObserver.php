<?php

namespace App\Observers;

use App\User;
use Illuminate\Support\Facades\Storage;

class UserObserver
{
    public function created(User $user)
    {
        $user->profile()->create([]);
    }

    public function deleted(User $user)
    {
        $avatarFile = $user->profile()->avatar_url;
        Storage::disk('public')->delete($avatarFile);
        $user->profile()->delete();
    }
}