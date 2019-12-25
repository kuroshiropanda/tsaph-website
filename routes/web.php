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

Auth::routes();

Route::get('/admin', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@dashboard');
Route::get('/applications', 'HomeController@applications');
Route::get('/teaminvite', 'HomeController@invite');

Route::get('/rules', function () {
    return view('rules');
});

Route::get('twitch/login', 'Auth\TwitchApplicationController@redirectToProvider');
Route::get('apply/callback', 'Auth\TwitchApplicationController@handleProviderCallback');

// Route::get('apply', 'ApplyController@index');

Route::post('apply/create', 'ApplyController@apply');
