<?php

namespace App\Providers;

use App\Admin;
use App\Post;
use App\tag;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		Schema::defaultStringLength(191);
		view()->composer('layouts.sidebar' , function($view){
            if (!in_array('guest' , request()->route()->middleware())){
                $view->with(['archives' => Post::archives() , 'tags' => tag::popularTags(),
                    'adminTags' => Admin::adminTags(Sentinel::getUser()->username)]);
            }
        });
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}
}
