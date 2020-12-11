@extends('layouts.app')

@section('panel-heading')
    @php
        $user_picture = $user->profile_picture ?? 'image.jpeg' ;
    @endphp
    <p class="text-center"><img src="{{asset("profile_picture/$user_picture")}}"
                                style="max-width: 50px; max-height: 50px; border-radius: 50%" alt="">
                                {{$user->username}}
    </p>
@endsection

@section('content')

    <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">User Profile </div>

                <div class="panel-body">

                    @if(\Cartalyst\Sentinel\Laravel\Facades\Sentinel::getUser()->id == $user->id)
                        <form action="{{ route('profile')  }}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="Email"></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="example@example.com" value="{{ $user->email }}" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="firstName"></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-file-signature"></i></span>
                            <input type="text" name="first_name" class="form-control" placeholder="first name" value="{{ $user->first_name }}" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lastName"></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-file-signature"></i></span>
                            <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{ $user->last_name }}" >
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
                            <input type="text" name="sec_answer" class="form-control" placeholder="security answer" value="{{ old("sec_answer") }}" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username"></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-signature"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="username" value="{{ $user->username }}" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dop"></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                            <input type="date" name="dop" class="form-control" placeholder="date op birth" value="{{ $user->dop }}" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="location"></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
                            <input type="text" name="location" class="form-control" placeholder="location" value="{{ $user->location }}" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="update_profile"></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-upload fa-lg"></i></span>
                            <input type="file" name="profile_picture" class="form-control" value="{{ old("profile_picture") }}" >
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="password">Type your password to update your profile</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-passport"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="password" value="{{ old("password") }}" required="" >
                        </div>
                    </div>

                    <div class="form-group">
                            <button type="submit"  class="form-control btn btn-success  " >Update Profile</button>
                    </div>

                </form>
                    @else
                            <ul class="list-group-item">
                                <li class="list-group-item">Name :: {{$user->username}}</li>
                                <li class="list-group-item">Email :: {{$user->email}}</li>
                                <li class="list-group-item">First name :: {{$user->first_name}}</li>
                                <li class="list-group-item">Last Name :: {{$user->last_name}}</li>
                                <li class="list-group-item">location :: {{$user->location}}</li>
                                <li class="list-group-item">Date Of Birth :: {{$user->dop}}</li>
                            </ul>
                    @endif


                </div>
            </div>
        </div>

@endsection
