<?php

namespace App\Http\Controllers;

use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function Symfony\Component\VarDumper\Tests\Fixtures\bar;

class UserController extends Controller
{
    public function getProfile($username){
        $user = User::whereUsername($username)->first();
        if ($user){
            return view('user.profile')->with('user' , $user);
        }

        if ($user->hasAnyAccess(['admin.*','moderator.*'])){
            return redirect()->route('admin.dashboard')->with('error' , 'invalid profile ');
        }elseif ($user->hasAnyAccess('user.*')){
            return redirect()->route('home')->with('error' , 'invalid profile ');
        }


    }

    public function postProfile(){

//        dd(\request()->all());
        $user = Sentinel::getUser();
        $data = \request()->validate([
            'email'      =>   "nullable|email|unique:users,email,$user->id",
            'username'  =>   "nullable|min:3|max:20|alpha_dash|unique:users,username,$user->id",
            'password'  =>   'required|string|min:6|max:32',
            'first_name'=>   'nullable|min:3|max:20|alpha',
            'last_name' =>   'nullable|min:3|max:20|alpha',
            'dop'       =>   'nullable|date',
            'location'  =>   ['regex:/^[a-zA-Z0-9_.]*$/' , 'nullable' , 'min:3' , 'max:60'],
            'profile_picture' => 'nullable|max:4999|mimes:jpg,jpeg,png',
            'sec_question'       =>   'nullable|string|in:who_is_your_favorite_teacher,where_are_you_from,what_is_your_hobby',
            'sec_answer'       =>   ['nullable','min:4' , 'max:55' , 'string' , 'regex:/[a-zA-Z0-9]*$/'],
        ]);

        if (Hash::check(\request('password') , $user->password)){

            if(\request()->hasFile('profile_picture')){
                $originName = \request()->file('profile_picture')->getClientOriginalName();
                $extensionName = \request()->file('profile_picture')->getClientOriginalExtension();
                $imageName = sha1(str_random(40) . time()) . '.' . $extensionName ;
                $imagePath = \request()->file('profile_picture')->move(public_path() . '/profile_picture/' . $imageName);
            }

            $user->email = \request('email') ?? $user->email ;
            $user->username = \request('username') ?? $user->username ;
            $user->first_name = \request('first_name') ?? $user->first_name ;
            $user->last_name = \request('last_name') ?? $user->last_name ;
            $user->dop = \request('dop') ?? $user->dop ;
            $user->location = \request('location') ?? $user->location ;
            $user->profile_picture = $imageName ?? $user->profile_picture ;
            $user->save();

            if ($user->hasAnyAccess(['admin.*','moderator.*'])){
                return redirect()->route('admin.dashboard');
            }elseif ($user->hasAnyAccess('user.*')){
                return redirect()->route('home')->with('success' , 'login in successfully');
            }

        }else{
            return back()->with('error' , 'password not correct');
        }

    }

}
