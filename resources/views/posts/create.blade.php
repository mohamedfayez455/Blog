@extends('layouts.app')

@section('content')

    <form action="{{route('posts.store')}}" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" value="{{old('title')}}" placeholder="Post Title">
        </div>

        <div class="form-group">
            <label for="body">Post Body</label>
            <textarea  class="form-control" name="body"  placeholder="Post Title"> {{old('body')}}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input  type="file" class="form-control" name="imagePath" />
        </div>

        <div class="form-group">
            <label for="tags">Tags</label>
            <input type="text" class="form-control" name="tags" value="{{old('tags')}}" placeholder="Post tags">
        </div>

        <div class="form-group">
            <input type="submit" value="release post" class="form-control">
        </div>

    </form>

@endsection