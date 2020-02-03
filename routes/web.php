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

Auth::routes();

// dashboard routes
Route::get('/admin', 'HomeController@index')->name('admin');
Route::get('/admin/profile/{user}/edit', 'UserController@edit')->middleware(['auth', 'password.confirm'])->name('user.edit');
Route::post('/admin/profile/{user}/update', 'UserController@update')->middleware('auth')->name('user.update');

Route::group(['middleware' => ['role:super admin']], function () {
    Route::get('/admin/users', 'HomeController@users')->name('users');
});

Route::group(['middleware' => ['role:super admin|admin|ads']], function () {
    Route::get('/admin/approved', 'HomeController@approved')->name('approved');
    // Route::post('/applicants/all/invite', 'ApplicantController@inviteAll')->name('invite.all');

    // Route::post('applicant/invite', 'ApplicantController@invite');
});

Route::group(['middleware' => ['role:super admin|admin|moderator|ads']], function () {
    Route::get('/admin/applicants', 'HomeController@applicants')->name('applicants');
    Route::get('/admin/denied', 'HomeController@denied')->name('denied');
    Route::get('/admin/members', 'MembersController@index')->name('members');
    Route::get('/admin/applicant/{id}', 'ApplicantController@show')->middleware('auth')->where('id', '[0-9]+')->name('applicant');

    // Route::post('applicant/{id}/approve', 'ApplicantController@approve')->name('applicant.approve');
    // Route::post('applicant/{id}/deny', 'ApplicantController@deny')->name('applicant.deny');
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
