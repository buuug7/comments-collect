<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Events\CommentReplied;
use App\Events\PostCommented;
use App\Notifications\CommentRepliedNotify;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class CommentController extends Controller
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
        $comments = Comment::latest();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        ]);

        $comment = Comment::create([
            'contents' => $request->contents,
            'post_id' => $request->post_id,
            'user_id' => $request->user()->id,
            'target_user_id' => $request->target_user_id,
            'target_comment_id' => $request->target_user_id,
        ]);


        event(new PostCommented(Post::find($request->post_id), $comment));

        $result = $comment->load('user');

        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        $result = Comment::with(['user', 'targetUser', 'targetComment', 'repliedComments'])
            ->where('id', $comment->id)->first();
        return response()->json($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return response()->json([
            'message' => 'deleted success',
        ]);
    }

    /**
     * Liked the specified comment resource
     * @param Request $request
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function like(Request $request, Comment $comment)
    {
        $request->user()->likedComments()->toggle($comment->id);

        $result = Comment::find($comment->id)->load(['user', 'targetUser', 'targetComment']);

        return response()->json($result);
    }

    /**
     * Reply the specified comment resource
     * @param Request $request
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function reply(Request $request, Comment $comment)
    {
        $this->validate($request, [
            'contents' => 'required',
        ]);

        $replyComment = Comment::create([
            'contents' => $request->contents,
            'post_id' => $request->post_id,
            'user_id' => $request->user()->id,
            'target_user_id' => $request->target_user_id,
            'target_comment_id' => $comment->id,
        ]);

        $result = $replyComment->load(['user', 'targetUser', 'targetComment']);

        event(new CommentReplied($comment, $replyComment));

        return response()->json($result);
    }
}
