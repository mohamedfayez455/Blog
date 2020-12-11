<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{

    public function getChangePassword(){
        return view('auth.change-password');
    }

    public function postChangePassword(){
        if (Sentinel::check()){
            $user = User::whereEmail(Sentinel::getUser()->email)->first();
            if ($user){
                \request()->validate([
                    'current_password' => 'required|min:6|max:32',
                    'password' => 'required|min:6|max:33|confirmed'
                ]);
                if (Hash::check(\request('current_password') , Sentinel::getUser()->password)){
                    $user->password = Hash::make(\request('password'));
                    $user->save();
                    if (Sentinel::hasAnyAccess(['moderator.*'  , 'admin.*'])){
                        return  redirect()->route('admin.dashboard')->with('success' , 'you updated password successfully');
                    }else{
                        return  redirect()->home()->with('success' , 'you updated password successfully');
                    }
                }else{
                    return redirect()->back()->with('error' , 'your password is not correct');
                }
            }else{
                return redirect()->back()->with('error' , 'you need to login first');
            }
        }else{
            return redirect()->back()->with('error' , 'you need to login first');
        }
    }
}
