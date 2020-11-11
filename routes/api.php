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

Route::namespace('api')->group(function(){
    Route::middleware('admin')->group(function(){
        Route::get('xlsx/{id}','ApiController@export');
        Route::get('fullMarks/{id}','ApiController@fullMarksExport');
        Route::post('getFullMarks/{id}','ApiController@getFullMarks');
        Route::post('addSchoolYear','ApiController@addSchoolYear');
        Route::post('switchSchoolYear','ApiController@switchSchoolYear');
        Route::post('getFinishData','ApiController@getFinishData');
        Route::post('importQuestion','ApiController@importQuestion');
        Route::post('createUsers','ApiController@createUsers');
    });

    Route::middleware('student')->prefix('users')->group(function(){
        Route::post('getScoresDetail','ApiController@getScoresDetail');
        Route::post('getScoresCount','ApiController@getScoresCount');
        Route::post('getScores','ApiController@getScores');
        Route::post('addScore','ApiController@addScore');
    });

    Route::get('getSchoolYear','ApiController@getSchoolYear');
    Route::get('getCategories','ApiController@getCategories');
    Route::get('getSchoolYearQuestions','ApiController@getSchoolYearQuestions');
    Route::post('getQuestions','ApiController@getQuestions');
    Route::post("checkPermission",'ApiController@checkPermission');
    Route::post('login','ApiController@login');
    Route::patch('logout','ApiController@logout');
});
