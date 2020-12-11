@extends('layouts.app')

@section('content')

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Rest Password</div>

                <div class="panel-body">

                <form action="{{ route('rest-password')  }}" method="POST">
                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="password"></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-passport"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="password" value="{{ old("password") }}" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password confirmation"></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-passport"></i></span>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="password confirmation" value="{{ old("password_confirmation") }}" required="">
                        </div>
                    </div>

                    <div class="form-group">
                            <button type="submit"  class="form-control btn btn-success  " >Submit New Password</button>
                    </div>

                </form>

                </div>
            </div>
        </div>

@endsection
