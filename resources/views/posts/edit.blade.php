@extends('layouts.app')

@section('content')
    <form action="{{route('posts.update' , $post->title) }}" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}

        <input type="hidden" name="_method" value="put"  >

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" value="{{$post->title}}" placeholder="Post Title">
        </div>

        <div class="form-group">
            <label for="body">Post Body</label>
            <textarea  class="form-control" name="body"  placeholder="Post Title"> {{$post->body}}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input  type="file" class="form-control" name="imagePath" />
        </div>

        <div class="form-group">
            <label for="tags">post Tags</label>
            <input type="text" class="form-control" name="tags" value="{{implode(' ' , $post->tags()->pluck('name')->toArray())}}" placeholder="Post tags">
        </div>

        <div class="form-group">
            <input type="submit" value="update post" class="form-control">
        </div>

    </form>

@endsection