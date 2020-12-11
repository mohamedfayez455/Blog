<?php

namespace App\Mail;

use Cartalyst\Sentinel\Activations\EloquentActivation;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserActivation extends Mailable
{
    use Queueable, SerializesModels;

    public $user , $activation ;

    public function __construct(EloquentUser $user , EloquentActivation  $activation)
    {
        $this->user  = $user;
        $this->activation  = $activation->code;
    }

    public function build()
    {
        return $this->markdown('emails.activation');

//        return $this->view('emails.activation');
    }
}
