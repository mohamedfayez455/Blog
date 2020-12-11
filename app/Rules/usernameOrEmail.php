<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class usernameOrEmail implements Rule
{
    public function passes($attribute, $value)
    {
        if (filter_var($value , FILTER_VALIDATE_EMAIL)){     //guknovarta@nedoz.com
            return request()->validate([
               $attribute => ['required' , 'emails' , 'regex:/(.*)@(gmail|yahoo|hotmail|nedoz)\.com/i']
            ],['invalid domain']);
        }elseif (preg_match('/^[a-zA-Z-_]*$/' , $value)){
            return request()->validate([
                $attribute  => 'required|alpha_dash|min:3|max:32'
            ],['user name is error']);
        }
        return false ;
    }

    public function message()
    {
        return 'The validation error message.';
    }
}
