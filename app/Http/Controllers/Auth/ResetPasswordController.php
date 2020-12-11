<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Reminder;
use Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ResetPasswordController extends Controller
{

    public function getPasswordRest($email, $token)
    {

        $user = User::whereEmail($email)->first();
        if ($user) {
            $user = Sentinel::findById($user->id);
//                dd(Reminder::exists($user)->code);
//            if (Reminder::exists($user)->code === $token) {
            if (Reminder::exists($user)) {
                Session::put('user', $user);
                Session::put('token', $token);
                return view('auth.rest-password');
            } else {
                return redirect()->route('login')->with('error', 'Invalid Token');
            }
        } else {
            return redirect()->route('login')->with('error', 'Email Dose Not Exists');
        }
    }

    public function postPasswordRest()
    {
        \request()->validate([
            'password' => 'required|min:8|max:32|confirmed'
        ]);
        if ($reminder = Reminder::complete(Session::get('user'), Session::get('token'), \request('password'))) {
            Reminder::removeExpired();
            Session::flush();
            return redirect()->route('login')->with('success', 'password has been changed successfully');
        } else {
            return redirect()->route('login')->with('error', 'try again later');
        }
    }
}
