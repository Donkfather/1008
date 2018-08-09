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
})->name('login');
Route::get('auth/{provider}/callback', 'SocialAuthController@callback');
Route::get('auth/{provider}/redirect', 'SocialAuthController@redirect');

Route::group(['middleware'=>['auth']],function(){
    Route::get('auth/logout','SocialAuthController@logout');
    Route::get('/points',function(){
        return \App\CheckinLocation::select(['event_id','lat','lng'])
            ->get()->groupBy('event_id');
    });
    Route::get('/events','EventsController@index');
    Route::get('/events/{event}/locations','EventsController@locations');
    Route::post('/events/{event}/checkin','EventsController@checkin');

});