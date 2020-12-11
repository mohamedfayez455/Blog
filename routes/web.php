<?php

Route::group(['namespace'   =>  'Auth'] , function (){

    Route::group(['middleware'   =>  'guest'] , function (){

        Route::get('register',[
            'uses' =>   'RegisterController@getRegister',
            'as'   =>   'register'
        ]);

        Route::post('register',[
            'uses' =>   'RegisterController@postRegister',
            'as'   =>   'register'
        ]);

        Route::get('login',[
            'uses' =>   'LoginController@getLogin',
            'as'   =>   'login'
        ]);

        Route::post('login',[
            'uses' =>   'LoginController@postLogin',
            'as'   =>   'login'
        ]);

        Route::get('/activate/{emails}/{token}' , 'EmailActivationController@activateUser');

        // rest password by email
        Route::get('/rest' , 'ForgotPasswordController@getForgetPassword')->name('rest');
        Route::post('/rest' , 'ForgotPasswordController@postForgetPassword')->name('rest');

        Route::get('/rest/{email}/{token}' , 'ResetPasswordController@getPasswordRest')->name('rest-password');
        Route::post('/rest-password' , 'ResetPasswordController@postPasswordRest')->name('rest-password');


        // rest password by question
        Route::get('/restByQuestion' , 'ResetPasswordByQuestionController@getPasswordRestByQuestion')->name('rest.question');
        Route::post('/restByQuestion/stage1' , 'ResetPasswordByQuestionController@postPasswordRestByQuestion1')->name('rest.question1');
        Route::post('/restByQuestion/stage2' , 'ResetPasswordByQuestionController@postPasswordRestByQuestion2')->name('rest.question2');
        Route::post('/restByQuestion/stage3' , 'ResetPasswordByQuestionController@postPasswordRestByQuestion3')->name('rest.question3');

    });

    Route::group(['middleware' => 'admin'] , function (){

        Route::get('/admin/dashboard' , function (){
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::get('change-password' , 'ChangePasswordController@getChangePassword')->name('change.password');
        Route::post('change-password' , 'ChangePasswordController@postChangePassword')->name('change.password');

    });

    Route::group(['middleware' => 'user:admin'] , function (){

        Route::any('logout',[
            'uses' =>   'LoginController@logout',
            'as'   =>   'logout'
        ]);

    });

});

Route::group(['middleware' => 'admin'] , function (){

    Route::resource('/posts' , 'PostController');
    Route::get('/unApprovedPosts' , 'PostController@ListUnApprovedPosts')->name('posts.unApproved');
    Route::post('/approvePost/{id}' , 'AdminController@approvePost')->name('post.approve');

    Route::resource('/tags' , 'TagController');
    Route::get('/popularTags' , 'TagController@sortByPopularity');

//    Route::resource('/comments' , 'CommentController');
    Route::get('/comments' , 'CommentController@index')->name('comments.index');
    Route::get('/comments/{comment}' , 'CommentController@show')->name('comments.show');
    Route::get('/comments/{comment}/{post}' , 'CommentController@edit')->name('comments.edit');
    Route::post('/comments/{post}' , 'CommentController@store')->name('comments.store');
    Route::put('/comments/{comment}' , 'CommentController@update')->name('comments.update');
    Route::delete('/comments/{comment}' , 'CommentController@destroy')->name('comments.destroy');

    Route::get('/replies/{reply}' , 'ReplyController@show')->name('replies.show');
    Route::get('/replies/{reply}/{post}' , 'ReplyController@edit')->name('replies.edit');
    Route::post('/replies/{comment}/{post}' , 'ReplyController@store')->name('replies.store');
    Route::put('/replies/{reply}/{comment}/{post}' , 'ReplyController@update')->name('replies.update');
    Route::delete('/replies/{reply}' , 'ReplyController@destroy')->name('replies.destroy');


});

Route::group(['middleware' => ['user' , 'admin']] , function (){

    Route::get('/profile/{username}' , 'UserController@getProfile')->name('profile');
    Route::post('/profile' , 'UserController@postProfile')->name('profile');

});

Route::get('/archives' , 'PostController@listByArchives')->name('archives');

Route::get('/user/dashboard' , function (){
    return view('user.dashboard');
})->name('user.dashboard');

Route::get('home' , function (){
    return view('home');
})->name('home');

Route::get('/' , function (){
    return view('welcome');
})->name('welcome');

Route::get('/roles' , function (){
    $role = Sentinel::getRoleRepository()->createModel()->create([
        'name' => 'Adminstrator',
        'slug' => 'admin',
        "permissions" => [
        "admin.create" => true,
        "admin.delete" => true,
        "admin.show"   => true,
        "admin.edit" => true,
        "admin.approve" => true
    ]
    ]);
});

Route::get('/get-online-users' , function (){

    if (\App\Admin::onlineUsers() !== NUll){
        foreach (\App\Admin::onlineUsers() as $user){
            return $user->roles()->first()->slug ;
        }
    }

});

Route::get('/upgradeUser' , function (){
    \App\Admin::upgradeUser( 1 , ['admin.show' => true , 'moderator.update' => false]);
});

Route::get('/downgradeUser' , function (){
//    \App\Admin::downgradeUser( 1 , ['admin.show' => false]);
    \App\Admin::downgradeUser( 1 , 'admin.delete');
});

Route::get('/delemeter' , function (){
   dd ( \App\tag::delimeters('this is mysql,php'));
});