<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ResetPasswordByQuestionController extends Controller
{

    public function getPasswordRestByQuestion(){
        Session::flash('info' , 'don\'t refresh page while rest password ');
        return view('auth.restByQuestion');
    }

    public function postPasswordRestByQuestion1(){
        \request()->validate([
            'email'     => 'required|email|exists:users,email',
            'dop'       =>'required|date',
            'location'  =>'required|string|exists:users,location',
        ]);
        $user = User::whereEmail(\request('email'))->first();
        $user = Sentinel::findById($user->id);
        if (Activation::completed($user)){
            $user = User::where(['email' =>\request('email') , 'dop' => \request('dop') ,
                'location' =>\request('location')])->first();
            if ($user){
                Session::put('user' , $user);
                Session::flash('success' , 'Stage 2 : answering the security question');
                return redirect()->back()->with('stage 2' , 'you have reached stage 2');
            }else{
                Session::flush();
                return redirect()->back()->with('error' , 'invalid data');
            }
        }else{
            Session::flush();
            return redirect()->back()->with('error' , 'account not activated yet');
        }
    }


    public function postPasswordRestByQuestion2(){
        \request()->validate([
            'sec_answer' => ['required' , 'min:2' , 'max:66' , 'regex:/^[a-zA-Z0-9]*$/' , 'string']
        ]);
        if (Session::exists('user')){
            $user = User::where(['email' => \Session::get('user')->email ,'dop' => Session::get('user') ->dop ,
                'location' => Session::get('user')->location , 'sec_answer' => \request('sec_answer') ,
                'sec_question' => \request('sec_question')])->first();
            if ($user){
//                Session::put('sec_answer' , \request('sec_answer'));
                return redirect()->back()->with(['success' => 'step 3 submit a password' , 'stage 3' => 'this is stage 3']);
            }else{
                Session::flush();
                return redirect()->back()->with('error' , 'invalid data');
            }
        }
    }


    public function postPasswordRestByQuestion3(){
        \request()->validate([
            'password' =>'required|min:6|max:32|confirmed',
        ]);
        if (Session::exists( 'user' )){
            $user = User::where(['email' => Session::get('user')->email ,
                'sec_answer' => Session::get('user')->sec_answer])->first();
            if ($user){
                $user->password = bcrypt(\request('password'));
                $user->save();
                Session::flush();
                return redirect()->route('login')->with('success' , 'password has been changed successfully');
            }else{
                Session::flush();
                return redirect()->back()->with('error' , 'invalid data');
            }
        }else{
            Session::flush();
            return redirect()->back()->with('error' , 'invalid data');
        }
    }


}
