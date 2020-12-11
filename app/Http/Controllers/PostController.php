<?php

namespace App\Http\Controllers;

use App\Post;
use App\tag;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function ListUnApprovedPosts(){
        $posts = Post::whereApproved(0)->orderByDesc('created_at')->get();
        return view('posts.index')->with('posts' , $posts);
    }

    public function listByArchives()
    {
        $posts = Post::approvedPosts()->filter(\request()->route('month') , \request()->route('year'))->get();
        return view('posts.index')->with('posts' , $posts);
    }
    public function index()
    {
        $posts = Post::approvedPosts()->get();
        return view('posts.index')->with('posts' , $posts);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        \request()->validate([
           'title' => 'required|string|min:6|max:55|unique:posts,title',
            'body' =>  ['required' , 'string' , 'min:6' , 'max:600' , 'regex:/^[a-zA-Z0-9- _.]*$/'],
            'imagePath'=> 'nullable|max:4999|image|mimes:png,jpg,jpeg',
            'tags' => ['required' , 'min:3' , 'max:32' , 'string' , 'regex:/^[a-zA-Z0-9_., ]*$/']
        ]);

        if (tag::asginTags(\request('tags'))){

            if(\request()->hasFile('imagePath')){
                $originName = \request()->file('imagePath')->getClientOriginalName();
                $extensionName = \request()->file('imagePath')->getClientOriginalExtension();
                $imageName = sha1(str_random(40) . time()) . '.' . $extensionName ;
                $imagePath = \request()->file('imagePath')->move(public_path() . '/images/' . $imageName);
            }

            $post = Post::create([
                'title' => \request('title'),
                'body' => \request('body'),
                'imagePath' => $imageName ?? NULL ,
                'admin_id' => Sentinel::getUser()->id,
            ]);

            if (is_array(Session::get('tags'))){
                foreach (Session::get('tags') as $tag){
                    $post->tags()->attach($tag);
                }
            }else{
                $post->tags()->attach(Session::get('tags'));
            }
            Session::forget('tags');
            return redirect()->route('posts.index')->with('success' , 'post created successfully');

        }
    }

    public function show(Post $post)
    {
        return view('posts.show' )->with('post' , $post);
    }

    public function edit(Post $post)
    {
        if ($post->admin_id !== Sentinel::getUser()->id ){
            return redirect()->back()->with('error' , 'invalid permission');
        }
        return  view('posts.edit' )->with('post' , $post);
    }

    public function update(Request $request, Post $post)
    {
        \request()->validate([
            'title' => "required|string|min:6|max:55|unique:posts,title,$post->id",
            'body' =>  ['required' , 'string' , 'min:6' , 'max:600' , 'regex:/^[a-zA-Z0-9-_ .]*$/'],
            'imagePath'=> 'nullable|max:4999|image|mimes:png,jpg,jpeg',
            'tags' => ['required' , 'min:3' , 'max:32' , 'string' , 'regex:/^[a-zA-Z0-9_., ]*$/']
        ]);

        if (tag::asginTags(\request('tags'))){

            if(\request()->hasFile('imagePath')){
                $originName = \request()->file('imagePath')->getClientOriginalName();
                $extensionName = \request()->file('imagePath')->getClientOriginalExtension();
                $imageName = sha1(str_random(40) . time()) . '.' . $extensionName ;
                $imagePath = \request()->file('imagePath')->move(public_path() . '/images/' . $imageName);
            }

            $post = Post::whereTitle($post->title)->update([
                'title' => \request('title'),
                'body' => \request('body'),
                'imagePath' => $imagePath ?? NULL ,
                'admin_id' => Sentinel::getUser()->id,
            ]);


            if ($post){
                $post = Post::whereTitle(\request('title'))->first();
                if(is_array(Session::get('tags'))){
                    for ($i = 0 ; $i < count(Session::get('tags')) ; $i++){
                        if ($i === 0){
                            $post->tags()->sync(Session::get('tags')[$i]);
                        }
                        $post->tags()->sync(Session::get('tags')[$i] , false);
                    }
                }else{
                    $post->tags()->sync(Session::get('tags'));
                }
                Session::forget('tags');
                return redirect()->route('posts.index')->with('success' , 'post updated successfully');
            }
        }
        return redirect()->route('posts.index')->with('error' , 'post dose not updated successfully');
    }

    public function destroy(Post $post)
    {
        if ($post->admin_id !== Sentinel::getUser()->id ){
            return redirect()->back()->with('error' , 'invalid permission');
        }
        if($post->imagePath !== NULL){
            File::delete('images/'.$post->imagePath);
        }
        $post->delete();
        return redirect()->route('posts.index')->with('success' , 'post deleted successfully');
    }


}
