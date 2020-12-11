<h1>Hello {{ $user->username }}</h1>

Click here to rest your password

<p>
    <a href="{{env('APP_URL' , 'http://localhost:8000'.'/reset/' .$user->email.'/'.$token )}}">Rest your Password</a>
</p>