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
    return view((auth()->guest())?'welcome':'dashboard');
});
Route::get('auth/logout','SocialAuthController@logout');
Route::get('auth/{provider}/callback', 'SocialAuthController@callback');
Route::get('auth/{provider}/redirect', 'SocialAuthController@redirect');
