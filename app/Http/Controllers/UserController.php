<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Return user profile
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        $user = $request->user()->load('profile');

        return response()->json($user);
    }


    /**
     * Update user profile
     * return new user profile and message if updated success
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'profile.website' => 'nullable|url',
            'profile.bio' => 'nullable',
        ]);

        $user = $request->user();
        $user->name = $request->name;
        $user->save();

        $request->user()->profile()->update([
            'website' => $request->profile['website'],
            'bio' => $request->profile['bio'],
        ]);

        return response()->json([
            'user' => $request->user()->load('profile'),
            'message' => 'success updated!',
        ]);
    }


    /**
     * Update the user avatar
     * new avatar url will be returned if success uploaded
     * @param Request $request
     * @return string
     */
    public function avatar(Request $request)
    {
        if (!$request->hasFile('avatar')) {
            return response()->json([
                'message' => 'No file uploaded!',
            ])->setStatusCode(422);
        }

        $avatarUrl = Storage::disk('public')
            ->put('avatars', $request->file('avatar'));

        // delete old avatar
        $oldAvatarUrl = $request->user()->profile->avatar_url;
        if ($oldAvatarUrl) {
            Storage::disk('public')->delete($oldAvatarUrl);
        }

        // and then update avatar url in the database
        $request->user()->profile()->update([
            'avatar_url' => $avatarUrl,
        ]);

        return response()->json([
            'avatar_url' => asset('storage/' . $avatarUrl),
        ]);
    }


    /**
     * Return the posts that the requested user created
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function posts(Request $request)
    {
        $result = $request->user()->posts()
            ->with(['user', 'tags'])->latest()->paginate(5);
        return response()->json($result);
    }


    /**
     * Return the posts that star by request user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function starPosts(Request $request)
    {
        $result = $request->user()->starPosts()
            ->with('user', 'tags')->latest()->paginate(5);
        return response()->json($result);
    }


    /**
     * Return comments that the request user created
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function comments(Request $request)
    {
        $result = $request->user()->comments()
            ->with(['user', 'targetUser', 'targetComment'])
            ->latest()->paginate(5);
        return response()->json($result);
    }


    /**
     * Return comments that the request user liked
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function likedComments(Request $request)
    {
        $result = $request->user()->likedComments()
            ->with(['user', 'targetUser', 'targetComment'])
            ->latest()->paginate(5);
        return response()->json($result);
    }


    /**
     * return the user unread notifications
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function notifications(Request $request)
    {
        $result = $request->user()->unreadNotifications()->paginate(15);
        return response()->json($result);
    }

}
