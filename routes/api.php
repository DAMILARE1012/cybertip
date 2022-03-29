<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([ 'middleware' => 'api', 'prefix' => 'auth'], function ($router) {

    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');


});



Route::group(['middleware' => 'auth:api'], function () {
    
    // Threat Intel Controller 

    Route::get('/threat_intels', 'ThreatIntelController@index');
    Route::get('/threat_intels/{search}', 'ThreatIntelController@search');
    Route::get('/threat_intels/{start_date}&{end_date}', 'ThreatIntelController@filterDate');

    
    Route::get('threats_intel/sortLast5days', 'ThreatIntelController@sortLast5days');

    Route::get('threats_intel/sortLast7days', 'ThreatIntelController@sortLast7days');

    // Admin Controller 
    Route::get('unapproved_users', 'AdminController@unapproved_users');
    Route::put('/users/{id}/approve', 'AdminController@approve');
    Route::delete('/users/{id}/decline', 'AdminController@decline');
    Route::get('/users/{id}/edit', 'AdminController@edit');
    Route::patch('/users/{user}', 'AdminController@update_role');
    Route::put('/users/{user}/updateprofile', 'AdminController@updateProfile');
    Route::delete('/users/{id}/remove_post', 'AdminController@decline');
    Route::get('/users', 'AdminController@usersList');
    Route::get('/users/approved', 'AdminController@approvedUsers');

    // Bookmark Controller 
    Route::post('/users/bookmark_record', 'BookmarkController@store');
    Route::get('/users/bookmark_records', 'BookmarkController@index');
    Route::get('/bookmark_posts/{search}', 'BookmarkController@search');
    Route::get('/bookmarks/{start_date}&{end_date}', 'BookmarkController@filterDate');

    // Report Controller
    Route::post('/users/report_list', 'ReportController@store');
    Route::get('/users/reports', 'ReportController@index');
    Route::get('/reports/{search}', 'ReportController@searchbyFrequency');
    Route::get('/reportsbyemail/{search}', 'ReportController@searchbyEmail');
    Route::delete('/reports/{id}', 'ReportController@removeReport');
});
