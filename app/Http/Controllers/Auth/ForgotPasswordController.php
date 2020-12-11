<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{

    public function getForgetPassword (){
        return view('auth.forgot-password');
    }

    public function postForgetPassword(){
        // validate data
        \request()->validate([
           'email'  => 'required|string'
        ]);
        // find user
        $user = User::whereUsernameOrEmail(\request('username') , \request('email'))->first();
//        dd(count($user));
        // check if user not exists return back
//        if (count($user) === 0){
        if (! $user){
            return redirect()->route('login')->with('error' , 'no such this username or email');
        }
        // find user by sentinel to able to pass this user to sentinel
        $user = Sentinel::findById($user->id);
        // check if user is activate
        if (Activation::completed($user)){
            // check if exists reminder if not create new reminder
            $reminder = Reminder::exists($user) ? : Reminder::create($user);
            // after create reminder send mail with this reminder
            $this->sendEmail($user , $reminder->code);
            // return back to login with success message
            return  redirect()->route('login')->with('success' , 'Rest code has been send to your account');
        }else{
            // if user not completed return back to login with error message
            return  redirect()->route('login')->with('error' , 'activate your account first');
        }
    }

    private function sendEmail($user , $token){
        Mail::send('emails.forgot-password' , ['user' => $user , 'token' => $token] , function ($message) use ($user) {
           $message->to($user->email);
           $message->subject("rest your password");
        });
    }

}
