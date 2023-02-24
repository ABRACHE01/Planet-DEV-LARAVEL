<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Resources\CommentResource;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{

     public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('IsAuthor');
        $this->middleware('IsAdmin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Display a listing of the resource.
        $comments = Comment::all();
        return response()->json(['comments' => $comments]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request)
    {
        //ceate a new comment
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user_id =
        $request->input('user_id');
        $comment->article_id = $request->input('article_id');
        $comment->save();
        return response()->json(['message' => 'Comment created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //Display the specified resource.
        return response()->json(['comment' => $comment]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        // if (auth()->user()->id !== $comment->user_id) {
        //     return response()->json(['error' => 'You are not authorized to update this comment'], 403);
        // }
        $comment->content = $request->input('content');
        $comment->save();

        return response()->json(['message' => 'Comment updated successfully', 'comment' => new CommentResource($comment)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {

        // if (auth()->user()->id !== $comment->user_id) {
        //     return response()->json(['error' => 'You are not authorized to delete this comment'], 403);
        // }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
