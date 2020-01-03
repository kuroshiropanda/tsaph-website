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
// Route::view('/about', 'about')->name('about');
// Route::view('/contact', 'contact')->name('contact');
// Route::view('/rules', 'rules')->name('rules');

// redirect routes
Route::redirect('/discord', 'https://discord.gg/pkuRuKe');
Route::redirect('/facebook', 'https://facebook.com/tsaphofficial');
Route::redirect('/fbgroup', 'https://www.facebook.com/groups/twitchsaph/');
Route::redirect('/twitch', 'https://twitch.tv/team/tsaph');

Auth::routes();

// dashboard routes
Route::get('/admin', 'HomeController@index')->name('admin');
Route::get('/admin/profile', 'HomeController@profile')->name('edit.profile');

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
    Route::get('/admin/members', 'MembersController@show')->name('members');

    // Route::post('applicant/{id}/approve', 'ApplicantController@approve')->name('applicant.approve');
    // Route::post('applicant/{id}/deny', 'ApplicantController@deny')->name('applicant.deny');
});

// twitch oauth routes
Route::get('twitch/login', 'Auth\TwitchApplicationController@redirectToProvider');
Route::get('apply/callback', 'Auth\TwitchApplicationController@handleProviderCallback');

// application routes
// Route::get('apply/{id}', 'ApplyController@index')->where('id', '[0-9]+')->name('apply');
Route::post('apply', 'ApplicantController@apply')->name('apply');
