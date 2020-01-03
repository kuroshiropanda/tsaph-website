<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->post('/members/update', 'MembersController@store');

Route::group(['middleware' => ['auth:api']], function() {
    Route::post('/admin/user/{user}/update', 'UserController@updateRole')->name('user.role');
    Route::get('/admin/applicant/{id}', 'HomeController@applicant')->where('id', '[0-9]+')->name('applicant');
    Route::post('/admin/applicant/{id}/update', 'ApplicantController@update')->where('id', '[0-9]+')->name('applicant.update');
});
