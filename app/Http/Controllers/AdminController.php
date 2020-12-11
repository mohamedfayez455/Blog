<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function approvePost($id){
        $approve = Admin::approve($id) ;
        if ($approve){
            return redirect()->route('posts.index')->with('success' , 'post approved successfully');
        }else{
            return redirect()->route('posts.index')->with('error' , ' failed to approve post');
        }
    }


}
