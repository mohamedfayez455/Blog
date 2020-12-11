@extends('layouts.app')

@section('content')
    @if(count($posts) > 0 )
        @foreach($posts as $post)
       <div class="well">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    @if($post->imagePath)
                        <img src="{{asset("images/$post->imagePath")}}" style="border-radius: 50% ; width: 50% " alt="Image">
                    @else
                        <img src="{{ asset('images/image.jpeg')}}" style="border-radius: 50% ; width: 50% " alt="Image">
                    @endif
                </div>
                <div class="col-md-4 col-sm-4">
                    <h3><a href="{{route('posts.show', $post->title)}}">{{$post->title}}</a></h3>
                    <small>Written {{$post->created_at}} By {{$post->admin->username}}</small>
                </div>
            </div>
       </div>
       @endforeach
    @else
        <div class="jumbotron">
            <p>there is no posts to show</p>
        </div>
    @endif
@endsection