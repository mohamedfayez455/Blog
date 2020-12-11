<?php

namespace App\Http\Controllers;

use App\tag;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TagController extends Controller
{

    public function index()
    {
        $tags = tag::all();
        return view('tags.index')->with('tags' , $tags);
    }

    public function sortByPopularity(){
        $tags = tag::popularTags();
        return view('tags.index')->with('tags' , $tags);
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store()
    {
        \request()->validate([
           'name' => 'required|min:3|max:32|string|unique:tags,name'
        ]);
        if (tag::asginTags(\request('name') , Sentinel::getUser()->id)){
            Session::forget('tags');
            return redirect()->route('tags.index')->with('success' , 'tags created successfully');
        }
        return redirect()->route('tags.index')->with('error' , 'tags does not created successfully');
    }

    public function show(tag $tag)
    {
        return view('tags.show')->with(['tag' => $tag , 'posts' =>$tag->posts ]);
    }

    public function edit(tag $tag)
    {
        return view('tags.edit')->with('tag' , $tag);
    }

    public function update( tag $tag)
    {
        \request()->validate([
            'name' => "required|min:3|max:32|string|unique:tags,name,$tag->id"
        ]);
        if (tag::asginTags(\request('name'))){
            Session::forget('tags');
            return redirect()->route('tags.index')->with('success' , 'tag updated successfully');
        }
        return redirect()->route('tags.index')->with('error' , 'Failed to tag update tags');
    }

    public function destroy(tag $tag)
    {
        $tag->delete();
        return redirect()->route('tags.index')->with('success' , 'tag deleted successfully');
    }
}
