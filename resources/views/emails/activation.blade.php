@component('mail::message')
#Email Activation
hello {{$user->username}}.
we are glad that you are here . let's hope you enjoy the website
in order to complete the process of activation
please click the button blew

@component('mail::button' , ['url' =>env('APP_URL' , 'http://localhost:8000') .'/activate/' . $user->email . '/' . $activation])
    Activate Account
@endcomponent

thanks,<br>

{{config('app.name')}}

@endcomponent