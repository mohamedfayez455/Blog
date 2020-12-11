@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('rest') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('emails') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input id="email" type="text" class="form-control" name="email" value="{{ old('emails') }}" required autofocus>

                                @if ($errors->has('emails'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('emails') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Email
                                </button>


                                <a class="btn btn-link" href="{{route('rest.question')}}">
                                    Reset Your Password By Question  ?
                                </a>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
