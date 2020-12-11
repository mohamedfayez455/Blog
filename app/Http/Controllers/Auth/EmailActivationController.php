<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Activation;
use Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailActivationController extends Controller
{
    public function activateUser($email , $token){
        if ($user = User::whereEmail($email)->first()){
            $user = Sentinel::findById($user->id);
            if (Activation::exists($user)){
                if (Activation::complete($user , $token)){
                    Activation::removeExpired();
                    if (Sentinel::login($user)){
                        return redirect()->home()->with('success' , 'Login Successfully');
                    }
                }
            }else{
                return redirect()->route('login')->with('error' , 'invalid token');
            }
        }else{
            return redirect()->route('login')->with('error' , 'incorrect error');
        }
    }
}
