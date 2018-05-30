<?php

namespace App\Http\Controllers\API;

use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index','show','comments']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['user', 'tags'])->latest()->paginate(5);
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'contents' => 'required',
            'reference' => 'required',
        ]);
        $post = Post::create([
            'contents' => $request->contents,
            'reference' => $request->reference,
            'user_id' => $request->user()->id,
        ]);

        if (count($request->tagsArray) > 0) {

            $post->tags()->detach();
            foreach ($request->tagsArray as $tag) {
                $t = Tag::firstOrCreate(
                    ['name' => $tag],
                    [
                        'slug' => str_slug($tag),
                        'user_id' => $request->user()->id
                    ]
                );
                $post->tags()->attach($t->id);
            }
        } else {
            $post->tags()->detach();
        }

        return response()->json([
            'post' => $post->load(['user', 'tags']),
            'message' => 'Created success!',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $result = $post->load(['user', 'tags']);
        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $this->validate($request, [
            'contents' => 'required',
            'reference' => 'required',
        ]);

        $post->update([
            'contents' => $request->contents,
            'reference' => $request->reference,
        ]);

        if (count($request->tagsArray) > 0) {

            $post->tags()->detach();
            foreach ($request->tagsArray as $tag) {
                $t = Tag::firstOrCreate(
                    ['slug' => str_slug($tag)],
                    [
                        'name' => $tag,
                        'user_id' => $request->user()->id
                    ]
                );
                $post->tags()->attach($t->id);
            }
        } else {
            $post->tags()->detach();
        }

        $result = $post->load(['user', 'tags']);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     * @throws
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return response()->json([
            'message' => 'deleted success',
        ]);
    }


    /**
     * request user star or dis star a specified resource
     * @param Request $request
     * @param Post $post
     * @return mixed
     */
    public function star(Request $request, Post $post)
    {

        $star = $request->user()->starPosts()->toggle($post->id);

        // trigger PostStar event if attached
        if (count($star['attached'])) {
            event(new PostStar($post, $request->user()));
        }

        return Post::find($post->id)->load(['user', 'tags']);
    }


    /**
     * return the comments under specified resource
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function comments(Request $request, Post $post)
    {
        $result = $post->comments()
            ->latest()
            ->with('user', 'targetUser', 'targetComment')
            ->paginate(5);
        return response()->json($result);
    }
}
