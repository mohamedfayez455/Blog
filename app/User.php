<?php

namespace App;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends EloquentUser
{
    use Notifiable;

    protected $fillable = [
        'name', 'emails', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function reolies(){
        return $this->hasMany(Reply::class);
    }

    public function getSecQuestionAttributes($value)
    {
        return $this->attributes['sec_question'] = ucfirst(str_replace('_' , ' ' , $value));
    }


}
