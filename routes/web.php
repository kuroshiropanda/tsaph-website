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

// normal view routes
Route::view('/', 'welcome')->name('homepage');
// Route::view('/about', 'about')->name('about');
// Route::view('/contact', 'contact')->name('contact');
// Route::view('/rules', 'rules')->name('rules');

// redirect routes
Route::redirect('/discord', 'https://discord.gg/pkuRuKe');
Route::redirect('/facebook', 'https://facebook.com/tsaphofficial');
Route::redirect('/twitch', 'https://twitch.tv/team/tsaph');

Auth::routes();

// dashboard routes
Route::get('/admin', 'HomeController@index')->name('home');
Route::get('/profile', 'HomeController@profile')->name('edit.profile');

Route::group(['middleware' => ['role:super admin']], function () {
    Route::get('/users', 'HomeController@users')->name('users');
});

Route::group(['middleware' => ['role:super admin|leader']], function () {
    Route::get('/approved', 'HomeController@approved')->name('approved');
});

Route::group(['middleware' => ['role:super admin|leader|admin']], function () {
    Route::get('/applicants', 'HomeController@applicants')->name('applicants');
    Route::get('/denied', 'HomeController@denied')->name('denied');
    Route::get('/members', 'HomeController@members')->name('members');
    Route::get('/applicant/{id}', 'HomeController@applicant')->where('id', '[0-9]+');
});

// twitch oauth routes
Route::get('twitch/login', 'Auth\TwitchApplicationController@redirectToProvider');
Route::get('apply/callback', 'Auth\TwitchApplicationController@handleProviderCallback');

// application routes
// Route::get('apply/{id}', 'ApplyController@index')->where('id', '[0-9]+')->name('apply');
Route::post('apply', 'ApplicantController@apply')->name('apply');
Route::get('applicant/{id}/approve', 'ApplicantController@approve');
Route::get('applicant/{id}/deny', 'ApplicantController@deny');
Route::post('applicant/invite', 'ApplicantController@invite');
