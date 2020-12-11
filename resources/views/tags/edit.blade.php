@extends('layouts.app')

@section('content')
    <form action="{{route('tags.update' , $tag->id) }}" method="POST" >
        {{csrf_field()}}

        <input type="hidden" name="_method" value="put"  >

        <div class="form-group">
            <label for="name">name</label>
            <input type="text" class="form-control" name="name" value="{{$tag->name}}" placeholder="tag name">
        </div>

        <div class="form-group">
            <input type="submit" value="update tag" class="form-control">
        </div>

    </form>

@endsection