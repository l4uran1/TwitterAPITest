<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Authenticate user
//Route::get('auth/twitter', 'Twitter\Auth\TwitterAuthController@redirectToProvider');
//Route::get('auth/twitter/callback', 'Twitter\Auth\TwitterAuthController@handleProviderCallback');

//Search tweets
//Route::get('search/tweets/', 'APIController@searchTweets');

Route::get('home', array('as' => 'home', 'uses' => function(){
  return view('home');
}));
