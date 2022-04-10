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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {

    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout/{id}', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});



Route::group(['middleware' => 'auth:api'], function () {

    // User Controller



    // Route::POST('/registration', 'Auth\RegisterController@register')->name('accept');

    // Threat Intel Controller 

    Route::get('/threat_intels', 'ThreatIntelController@index');
    Route::get('/threat_intels/{search}', 'ThreatIntelController@search');
    Route::get('/threat_intels/{start_date}&{end_date}', 'ThreatIntelController@filterDate');

    Route::get('threats_intel/sort24hrs/{value}', 'ThreatIntelController@sort24hrs');
    Route::get('threats_intel/sort7days/{value}', 'ThreatIntelController@sort7days');
    Route::get('threats_intel/sortMonth/{value}', 'ThreatIntelController@sortMonth');
    Route::get('threats_intel/anytime/{value}', 'ThreatIntelController@anytime');
    Route::get('/unique_source', 'ThreatIntelController@uniqueSource');
    Route::get('/unique_geolocations', 'ThreatIntelController@uniquegeoLocation');
    Route::get('/multi_search', 'ThreatIntelController@multiSearch');
    // Route::get('threats_intel/multidate_sort', 'ThreatIntelController@multiDateSort');


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
    // Route::get('/users/online', 'AdminController@onlineUsers');

    // Bookmark Controller 
    Route::post('/users/bookmark_record', 'BookmarkController@store');
    Route::get('/users/bookmark_records', 'BookmarkController@index');
    Route::get('/all_bookmark_records', 'BookmarkController@indexFull');
    Route::get('/bookmark_posts/{search}', 'BookmarkController@search');
    Route::get('/bookmarks/{start_date}&{end_date}', 'BookmarkController@filterDate');
    Route::delete('/bookmarks/{id}', 'BookmarkController@removeBookmark');
    Route::get('bookmarks/sortLast5days', 'BookmarkController@sortLast5days');
    Route::get('bookmarks/sortLast7days', 'BookmarkController@sortLast7days');

    // Report Controller
    Route::post('/users/report_list', 'ReportController@store');
    Route::get('/users/reports', 'ReportController@index');
    Route::get('/reports/{search}', 'ReportController@search');
    Route::delete('/reports/{id}', 'ReportController@removeReport');
    Route::put('/bookmark_records/{id}', 'ReportController@changeReportFrequency');


    // Activity Record Controller

});

// Users' Password Registration
Route::get('/password_reset', 'UsersController@getresetPassword')->name('password_reset');
Route::put('/password_reset', 'UsersController@resetPassword')->name('password_reset');

// Route::get('/registration/{token}', 'UsersController@registration_view')->name('registration');


// Route::get('/invitation_password_reset/{$token}', 'UsersController@getinvitationPwdReset')->name('invitation_password_reset');

// User Controller
Route::post('/users/invite', 'UsersController@process_invites')->name('process_invite');

Route::get('/invitation_password_reset', 'UsersController@getinvitationPwdReset')->name('invitation_password_reset');
Route::put('/users/invitation_set_password', 'UsersController@invitationSetPassword');

Route::get('/online_users', 'ActivityRecordController@onlineUsers');
Route::get('/offline_users', 'ActivityRecordController@offlineUsers');

// Permission
Route::get('/users/permission_list', 'UsersController@indexPermissionList');
Route::get('/users/permission_list/{value}', 'UsersController@searchList');



// Digital Profile Controller
Route::post('/digital_profile', 'ProfileController@store');
Route::get('/digital_profile', 'ProfileController@index');
Route::get('/digital_profile/{search}', 'ProfileController@searchProfile');
Route::put('/digital_profile/{id}', 'ProfileController@updateProfile');