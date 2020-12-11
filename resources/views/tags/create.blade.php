@extends('layouts.app')

@section('panel heading')
    Tags
@endsection
@section('content')

    <form action="{{route('tags.store')}}" method="POST" >
        {{csrf_field()}}

        <div class="form-group">
            <label for="name">name</label>
            <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="tage name">
        </div>

        <div class="form-group">
            <input type="submit" value="release tag" class="form-control">
        </div>

    </form>

@endsection