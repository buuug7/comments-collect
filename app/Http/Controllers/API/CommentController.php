<?php

namespace App\Http\Controllers\API;

use App\Comment;
use App\Events\CommentReplied;
use App\Events\PostCommented;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::latest()->paginate(5);
        return response()->json($comments);
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
            'commentable_id' => $request->commentable_id,
            'commentable_type' => $request->commentable_type,
            'user_id' => $request->user()->id,
            'target_user_id' => $request->target_user_id,
            'target_comment_id' => $request->target_user_id,
        ]);

        if ($request->commentable_type == 'App\Post') {
            event(new PostCommented(Post::find($request->commentable_id), $comment));
        }

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
            'commentable_id' => $request->commentable_id,
            'commentable_type' => $request->commentable_type,
            'user_id' => $request->user()->id,
            'target_user_id' => $request->target_user_id,
            'target_comment_id' => $comment->id,
        ]);

        $result = $replyComment->load(['user', 'targetUser', 'targetComment']);

        event(new CommentReplied($comment, $replyComment));

        return response()->json($result);
    }
}
