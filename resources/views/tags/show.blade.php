@extends('layouts.app')

@section('panel-heading')
<p class="text-center"> {{$tag->posts->count() . ' posts have ' .$tag->name.'tag' }} Post </p>
@endsection

@section('content')
    @if(count($posts) )
        @foreach($posts as $post)
            <ul class="list-group">
                <li class="list-group-item"><a href="{{route('posts.show' ,$post->title)}}">{{$post->title}}</a></li>
                <li class="list-group-item">{{$post->body}}</li>
                <li class="list-group-item">{{$post->admin->username}}</li>
            </ul>
        @endforeach

    @else
        <div class="jumbotron">
            <p>there is no posts to show</p>
        </div>
    @endif
@endsection