<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Reply;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class ReplyController extends Controller
{

    public function store(Comment $comment , Post $post)
    {
//        dd(\request()->all());
        \request()->validate([
            'comment' => 'required|min:3|max:300',
        ]);
        $reply = new Reply() ;
        $reply->body = \request('comment');
        $reply->user_id = Sentinel::getUser()->id;
        $reply->comment()->associate($comment);
        $reply->post()->associate($post);
        $reply->save();

        return back()->with('success' , 'reply add successfully');
    }


    public function show(Reply $reply)
    {
        return view('posts.show')->with('post' , $reply->post);
    }


    public function edit(Reply $reply , Post $post)
    {
        return view('posts.show')->with(['post' => $post , 'reply' => $reply]);
    }


    public function update(Reply $reply , Comment $comment , Post $post)
    {
        \request()->validate([
            'comment' => 'required|min:3|max:300',
        ]);
        $reply->update([
            'body'   => \request('comment'),
            'updated_at' => date('Y-m-d H:i:m')
        ]) ;
        $reply->post()->associate($post);
        $reply->comment()->associate($comment);
        return redirect()->route('posts.show' , $post->title)->with('success' , 'reply add successfully');
    }

    public function destroy(Reply $reply)
    {
        $reply->delete();
        return back()->with('success' , 'reply deleted successfully');
    }
}
