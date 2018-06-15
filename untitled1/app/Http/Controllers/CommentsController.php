<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\PostCommentRequest;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(PostCommentRequest $request)
    {
        Comment::create(array_merge($request->all(),['user_id'=>\Auth::user()->id]));

        return redirect()->action('PostsController@show',['id'=>$request->get('discussion_id')]);
    }
}
