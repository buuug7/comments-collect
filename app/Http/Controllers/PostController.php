<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use Illuminate\Http\Request;

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
        $posts = Post::with(['user','collectedUsers'])->latest()->get();
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

        if ($request->tags) {
            $post->tags()->attach($request->tags);
        }

        return redirect()
            ->action('PostController@show', ['id' => $post,])
            ->with('status', 'created success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $result = $post->load(['user', 'collectedUsers']);
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

        if ($request->tags) {
            $post->tags()->detach();
            $post->tags()->attach($request->tags);
        }

        return redirect()->action('PostController@show', ['id' => $post,])
            ->with('status', 'updated success');
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

        return Post::find($post->id)->load(['user', 'collectedUsers']);
    }
}
