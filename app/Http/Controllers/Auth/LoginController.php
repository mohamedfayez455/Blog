<?php

namespace App\Http\Controllers\Auth;

use App\Rules\usernameOrEmail;
use App\User;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{

    public function getLogin(){
        return view('auth.login');
    }

    public function postLogin(Request $request){
        //validate data
        $data = \request()->validate([
            'emails'     =>  new usernameOrEmail(),
            'password'   =>  'required|min:6|max:32',
            'remember'   => 'in:on,null'
         ]);

        $remember = false ;
        if (\request('remember') === 'on'){
            $remember = true ;
        }

        try {
            $user = Sentinel::login(['login' => \request('login')  ,'password' => \request('password')] , $remember);
            if ($user)
            {
                // redirect based on permission
                if ($user->hasAnyAccess(['admin.*','moderator.*'])){
                    return redirect()->route('admin.dashboard');
                }elseif ($user->hasAnyAccess('user.*')){
                    return redirect()->route('home')->with('success' , 'login in successfully');
                }
            }
            // if data not correct
            return redirect()->route('login')->with('error' , 'invalid login');
        }catch (NotActivatedException $e){
            return redirect()->route('login')->with('error' , 'activate your account first');
        }catch (ThrottlingException $e){
            return redirect()->route('login')->with('error' , $e->getMessage());
        }
    }



    public function logout(){
        Sentinel::logout();
        return redirect()->route('login')->with('info' , 'came back soon');
    }

}





