@extends('layouts.app')

@section('content')
    @if(count($tags) > 0 )
        <ul>
            @foreach($tags as $tag)

                <li class="list-group-item"><a href="{{route('tags.show' , $tag->id)}}">{{$tag->name}}</a> </li>
            @endforeach
        </ul>
    @else
        <div class="jumbotron">
            <p>there is no tags to show</p>
        </div>
    @endif
@endsection