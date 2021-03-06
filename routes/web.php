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
Route::view('/', 'welcome')->name('home');
Route::view('/about', 'home.about')->name('about');
Route::view('/contact', 'home.contact')->name('contact');
Route::view('/rules', 'home.rules')->name('rules');
Route::get('/members', 'MembersController@memberlist')->name('member.list');

// redirect routes
Route::redirect('/discord', 'https://discord.gg/bQd7cSm');
Route::redirect('/facebook', 'https://facebook.com/tsaphofficial');
Route::redirect('/fbgroup', 'https://facebook.com/groups/twitchsaph');
Route::redirect('/twitch', 'https://twitch.tv/team/tsaph');
Route::redirect('/reddit', 'https://reddit.com/r/tsaph');
Route::redirect('/interview', 'https://discord.gg/vbP8yTh')->name('interview');

Auth::routes();

// dashboard routes
Route::middleware('auth')->group(function () {
    Route::get('/admin', 'HomeController@index')->name('admin');
    Route::get('/admin/profile/{user}/edit', 'UserController@edit')->middleware('password.confirm')->name('user.edit');
    Route::get('/admin/profile/{user}/change_password', 'UserController@password')->middleware('password.confirm')->name('user.password');
    Route::patch('/admin/profile/{user}', 'UserController@update')->name('user.update');
    Route::patch('/admin/profile/{user}/password', 'UserController@updatePassword')->name('user.update.password');

    Route::middleware('role:super admin')->group(function () {
        Route::delete('/admin/user/{user}', 'UserController@destroy')->where('user', '[0-9]+')->name('user.destroy');
        Route::patch('/admin/user/{user}', 'UserController@updateRole')->where('user', '[0-9]+')->name('user.update.role');
        Route::delete('/admin/applicant/{applicant}', 'ApplicantController@destroy')->name('applicant.destroy');
        Route::patch('/admin/applicant/{applicant}', 'ApplicantController@update')->name('applicant.update');
    });

    Route::middleware('role:super admin|admin|moderator|ads')->group(function () {
        Route::get('/admin/users', 'UserController@index')->name('users');
        Route::get('/admin/members', 'MembersController@index')->name('members');
        Route::get('/admin/applicants', 'ApplicantController@index')->name('applicant.index');
        Route::get('/admin/denied', 'HomeController@denied')->name('denied');
        Route::get('/admin/approved', 'HomeController@approved')->name('approved');
        Route::get('/admin/applicant/{applicant}', 'ApplicantController@show')->name('applicant.show');
        Route::get('/admin/applicant/{applicant}/edit', 'ApplicantController@edit')->name('applicant.edit');
        Route::get('/admin/feedback', 'FeedbackController@index')->name('feedback.index');
    });

    Route::middleware('role:super admin|admin|moderator')->group(function () {
        Route::post('/admin/applicant/{applicant}/process', 'ApplicantController@processApplicant')->where('applicant', '[0-9]+')->name('applicant.process');
    });
});

// twitch oauth routes
Route::get('apply', 'Auth\TwitchApplicationController@redirectToProvider')->name('apply');
Route::get('apply/callback', 'Auth\TwitchApplicationController@handleProviderCallback');
Route::get('form', 'ApplicantController@create')->name('applicant.create');
Route::post('applicant/store', 'ApplicantController@store')->name('applicant.store');

Route::get('discord/connect', 'Auth\DiscordController@redirectToProvider')->name('discord.auth');
Route::get('discord/callback', 'Auth\DiscordController@handleProviderCallback');

Route::post('feedback/store', 'FeedbackController@store')->name('feedback.store');
