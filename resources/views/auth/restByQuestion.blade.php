@extends('layouts.app')

@section('panel-heading')
    <p class="text-center">{{Session::get('stage 2') ?? Session::get('stage 3') ?? 'rest your password'}}</p>
@endsection

@section('content')

    @if(session('stage 2'))

        <form action="{{ route('rest.question2') }}" method="post">
            {{csrf_field()}}

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
                <label for="sec_answer">answer your question</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="text" class="form-control" name="sec_answer" placeholder="your answer">
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success form-control">
                    <i class="fa fa-spin fa-cog fa-lg"></i>
                    <span class="sr-only"></span>
                    Go to step 3
                </button>
            </div>


        </form>

    @elseif(session('stage 3'))
        <form action="{{route('rest.question3')}}" method="post">
            {{csrf_field()}}


            <div class="form-group">
                <label for="password">password</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" name="password" placeholder="password">
                </div>
            </div>


            <div class="form-group">
                <label for="password">password confirmation</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="confirm password">
                </div>
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-success form-control">
                    <i class="fa fa-spin fa-cog fa-lg"></i>
                    <span class="sr-only"></span>
                    change password
                </button>
            </div>

        </form>

    @else

        <form action="{{route('rest.question1')}}" method="post">
            {{csrf_field()}}


            <div class="form-group">
                <label for="email">email</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" class="form-control" name="email" placeholder="email">
                </div>
            </div>


            <div class="form-group">
                <label for="location">location</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="text" class="form-control" name="location" placeholder="location">
                </div>
            </div>

            <div class="form-group">
                <label for="dop">date of birth</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="date" class="form-control" name="dop" placeholder="date of birth">
                </div>
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-success form-control">
                    <i class="fa fa-spin fa-cog fa-lg" aria-hidden="true"></i>
                    Go to step 2
                </button>
            </div>



            <a class="btn btn-link" href="{{route('rest')}}">
                Reset Your Password By Email?
            </a>

        </form>

    @endif


@endsection