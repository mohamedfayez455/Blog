<?php

namespace App\Http\Controllers\Auth;

use Activation;
use App\Mail\UserActivation;
use Illuminate\Support\Facades\Mail;
use Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{

    public function getRegister()
    {
        return view('auth.register');
    }

    public function postRegister(Request $request){
        // validation
        $data = \request()->validate([
           'email'      =>   'required|email|unique:users,email',
            'username'  =>   'required|min:3|max:20|alpha_dash|unique:users,username',
            'password'  =>   'required|string|min:6|max:32|confirmed',
            'first_name'=>   'required|min:3|max:20|alpha',
            'last_name' =>   'required|min:3|max:20|alpha',
//            'dop'       =>   'required|date:before_or_equal:2000-01-01|date_format:Y-m-d',
            'dop'       =>   'required|date',
            'location'  =>   ['regex:/^[a-zA-Z0-9_.]*$/' , 'required' , 'min:3' , 'max:60'],
            'sec_question'       =>   'required|string|in:who_is_your_favorite_teacher,where_are_you_from,what_is_your_hobby',
            'sec_answer'       =>   ['required','min:4' , 'max:55' , 'string' , 'regex:/[a-zA-Z0-9]*$/'],
        ]);
//        dd($data);
        // register
        $user = Sentinel::register($data);
        // activate user
        $activation  = Activation::create($user);
        //send mail
//        dd($activation);
        Mail::to($user)->send( new UserActivation($user , $activation));
        // attach role
        $role = Sentinel::findRoleBySlug("user");
        $role->users()->attach($user);
        // return to login page
        return redirect()->route('login')->with('success' , 'you have been Register successfully , please Activate your Account');
    }

}
