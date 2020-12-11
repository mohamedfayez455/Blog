<?php

namespace App;

use Activation;
use Cartalyst\Sentinel\Users\EloquentUser;
use Sentinel;
use Illuminate\Database\Eloquent\Model;

class Admin extends EloquentUser
{
    protected $table = 'users' ;

    public static function onlineUsers(){
        $users = User::pluck('id')->all();
        foreach ($users as $user){
            if (Activation::completed(static::find($user))){
                $onlineUser[] = Sentinel::findByPersistenceCode( Sentinel::findById($user)->persistences->first()->code );
            }
            continue ;
        }
        return $onlineUser ?? 'no online Users' ;
    }


    public static function upgradeUser($id , $permissions){
        $user = Sentinel::findById($id);
        if ($user->hasAccess('admin.*')){
            return false ;
        }
        if (is_array($permissions)){
            foreach ($permissions as $permission => $value){
                $user->updatePermission($permission , $value , true)->save();
            }
            return  true;
        }
        else{
            $user->updatePermission($permissions , true , true)->save();
            return  true;
        }
        return false;
    }


    public static function downgradeUser($id , $permissions){
        $user = Sentinel::findById($id);
        if ($user->hasAccess('admin.*')){
            return false ;
        }
        if (is_array($permissions)){
            foreach ($permissions as $permission => $value){
                $user->updatePermission($permission , $value , true)->save();
            }
            return  true;
        }else{
//            $user->updatePermission($permissions , false , true)->save();
            $user->removePermission($permissions)->save();
            return  true;
        }
        return false;
    }


    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function tags(){
        return $this->hasMany(tag::class);
    }

    public static function adminTags($username){
        return static::whereUsername($username)->first()->tags ;
    }

    public static function approve($id){
        $post = Post::find($id)->whereApproved(0)->first();
        if ($post){
            $post->approved = 1 ;
            $post->approved_by = \Sentinel::getUser()->username ;
            $post->approved_at = date('Y-m-d H:i:s') ;
            $post->save();
            return true ;
        }
        return  false ;
    }

}
