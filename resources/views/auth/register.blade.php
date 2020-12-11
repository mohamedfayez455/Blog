@extends('layouts.app')

@section('content')

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-body">

                <form action="{{ route('register')  }}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="Email"></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="example@example.com" value="{{ old("email") }}" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="firstName"></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-file-signature"></i></span>
                            <input type="text" name="first_name" class="form-control" placeholder="first name" value="{{ old("first_name") }}" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lastName"></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-file-signature"></i></span>
                            <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{ old("last_name") }}" required="">
                        </div>
                    </div>

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
                        <label for="sec_question">security question</label>
                        <select name="sec_question" class="form-control">
                            <option selected disabled> Pick up a Question</option>
                            <option value="who_is_your_favorite_teacher">who is your favorite teacher ? </option>
                            <option value="where_are_you_from">where are you from ? </option>
                            <option value="what_is_your_hobby">what is your hobby ? </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sec_answer"></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="text" name="sec_answer" class="form-control" placeholder="security answer" value="{{ old("sec_answer") }}" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username"></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-signature"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="username" value="{{ old("username") }}" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dop"></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                            <input type="date" name="dop" class="form-control" placeholder="date op birth" value="{{ old("dop") }}" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="location"></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
                            <input type="text" name="location" class="form-control" placeholder="location" value="{{ old("location") }}" required="">
                        </div>
                    </div>

                    <div class="form-group">
                            <button type="submit"  class="form-control btn btn-success  " >Register</button>
                    </div>


                    <a class="btn btn-link" href="{{route('login')}}">
                        Login?
                    </a>

                </form>

                </div>
            </div>
        </div>

@endsection
