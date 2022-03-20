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
    Route::get('/threat_intels', 'ThreatIntelController@index');
    Route::get('/threat_intels/{search}', 'ThreatIntelController@search');
    Route::get('/threat_intels/{start_date}&{end_date}', 'ThreatIntelController@filterDate');

    
    Route::get('threats_intel/sortLast5days', 'ThreatIntelController@sortLast5days');

    Route::get('threats_intel/sortLast7days', 'ThreatIntelController@sortLast7days');

    Route::get('unapproved_users', 'AdminController@unapproved_users');
    Route::put('/users/{id}/approve', 'AdminController@approve');
    Route::delete('/users/{id}/decline', 'AdminController@decline');
    Route::get('/users/{id}/edit', 'AdminController@edit');
    Route::patch('/users/{user}', 'AdminController@update_role');


    Route::get('/users', 'AdminController@usersList');
    Route::get('/users/approved', 'AdminController@approvedUsers');
});
