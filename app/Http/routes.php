<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('pages/login');
});

Route::get('/index', function () {
    return view('pages/index');
});

Route::resource('/user', 'UserController');

Route::get('/findByPersonalID','UserController@findByPersonalID' );

Route::get('/group','GroupController@group' );

Route::resource('/exam', 'ExamController');

Route::get('/section/save', 'SectionController@store');

Route::get('/addGroup', 'GroupController@ManageGroup');

Route::get('/findAllExam', 'ExamController@findAllExam');

Route::get('/checkExamByName', 'ExamController@checkExamByName');

Route::get('/findAllSection', 'SectionController@findAllSection');

Route::get('/findMySection', 'SectionController@findMySection');

Route::get('/section/edit', 'SectionController@edit');

Route::get('/section/delete', 'SectionController@destroy');

Route::get('/addExam{id}', 'ExamController@create');

Route::get('/createTextFile', 'ExamController@createTextFile');

Route::post('/uploadFile', 'ExamController@uploadFile');

Route::get('/createExam', 'ExamController@store');

Route::get('/Group/delete', 'GroupController@destroy');

Route::get('/readFile', 'ExamController@readFile');

Route::get('/deleteExam/{id}', 'ExamController@destroy');

Route::get('/editExam{id}', 'ExamController@edit');

Route::get('/findExamByID/{id}', 'ExamController@show');

Route::get('/updateExam', 'ExamController@update');

Route::get('/Group/edit', 'GroupController@edit');

Route::get('/findCreaterByPersonalID/{PID}', 'UserController@findCreaterByPersonalID');

Route::get('/createKeyword', 'KeywordController@store');

Route::get('/findKeywordByEID', 'KeywordController@findKeywordByEID');

Route::get('/updateKeyword', 'KeywordController@update');

Route::get('/deleteKeyword', 'KeywordController@destroy');

Route::get('/findAllGroup', 'GroupController@findAllGroup');

Route::get('/findMyGroup', 'GroupController@findMyGroup');