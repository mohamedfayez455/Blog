<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index()
    {
        $comments = Comment::all();
        return view('comments.index');
    }

    public function create()
    {
        //
    }


    public function store(Post $post)
    {
        \request()->validate([
            'comment' => 'required|min:3|max:300',
        ]);
        $comment = new  Comment();
        $comment->body = \request('comment');
        $comment->user_id = Sentinel::getUser()->id;
        $comment->post()->associate($post);
        $comment->save();

        return redirect()->back()->with('success' , 'comment added successfully');
    }


    public function show(Comment $comment)
    {
        return view('posts.show')->with('post' , $comment->post());
    }


    public function edit(Comment $comment , Post  $post)
    {
//        dd($post);
        return view('posts.show')->with(['comment' => $comment , 'post' => $post]);
    }


    public function update( Comment $comment)
    {
        \request()->validate([
            'comment' => 'required|min:3|max:300',
        ]);
        $comment->update([
            'body' => \request('comment'),
            'user_id' => Sentinel::getUser()->id,
        ]);
        return redirect()->route('posts.show' , $comment->post->title)->with('success' , 'comment updated successfully');

    }


    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('success' , 'comment deleted successfully');
    }
}
