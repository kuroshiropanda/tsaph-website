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
    Route::post('/admin/profile/{user}/update', 'UserController@update')->name('user.update');
    Route::post('/admin/profile/{user}/update/password', 'UserController@updatePassword')->name('user.update.password');

    Route::group(['middleware' => ['role:super admin']], function () {
        Route::post('/admin/user/{user}/delete', 'UserController@destroy')->name('user.delete');
        Route::post('/admin/user/{user}/role/update', 'UserController@updateRole')->where('applicant', '[0-9]+')->name('update.role');
        Route::post('/admin/applicant/{applicant}/delete', 'ApplicantController@destroy')->name('applicant.delete');
        Route::post('/admin/applicant/{applicant}/data', 'ApplicantController@updateData')->name('applicant.data');
        Route::post('/admin/applicant/{applicant}/update', 'ApplicantController@update')->name('applicant.update');
        Route::post('/admin/members/update', 'MembersController@update')->name('members.update');
    });

    Route::group(['middleware' => ['role:super admin|admin|ads']], function () {
        Route::get('/admin/approved', 'HomeController@approved')->name('approved');
    });

    Route::group(['middleware' => ['role:super admin|admin|moderator|ads']], function () {
        Route::get('/admin/users', 'HomeController@users')->name('users');
        Route::get('/admin/applicants', 'HomeController@applicants')->name('applicants');
        Route::get('/admin/denied', 'HomeController@denied')->name('denied');
        Route::get('/admin/members', 'MembersController@index')->name('members');
        Route::get('/admin/applicant/{applicant}', 'ApplicantController@show')->where('id', '[0-9]+')->name('applicant');
    });

    Route::group(['middleware' => ['role:super admin|admin|moderator']], function () {
        Route::post('/admin/applicant/{applicant}/process', 'ApplicantController@processApplicant')->where('applicant', '[0-9]+')->name('applicant.process');
    });
});

// twitch oauth routes
Route::get('apply', 'Auth\TwitchApplicationController@redirectToProvider')->name('apply');
Route::get('apply/callback', 'Auth\TwitchApplicationController@handleProviderCallback');

// discord oauth routes
Route::get('discord/login', 'Auth\DiscordController@redirectToProvider')->name('discord.login');
Route::get('discord/callback', 'Auth\DiscordController@handleProviderCallback');

// application routes
// Route::get('apply/{id}', 'ApplyController@index')->where('id', '[0-9]+')->name('apply');
Route::post('applicant/create', 'ApplicantController@create')->name('applicant.create');
