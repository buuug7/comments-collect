<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        return view('posts.create', [
            'tags' => $tags,
        ]);
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

        $result = $post->load(['user', 'tags']);

        return response()->json($result);
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::all();
        return view('posts.edit', [
            'post' => $post,
            'tags' => $tags,
        ]);
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

        $result = $post->load(['user', 'tags']);

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return response()->json([
            'message' => 'deleted success',
        ]);
    }

    // more // more // more //


    public function collect(Request $request, Post $post)
    {
        $result = $request->user()->collectedPosts()->toggle($post->id);

        return Post::find($post->id)->load(['user', 'tags']);
    }
}
