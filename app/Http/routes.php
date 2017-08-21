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

//--------------------------- UserController ---------------------------

Route::resource('/user', 'UserController');

Route::get('/findByPersonalID','UserController@findByPersonalID' );

Route::get('/findCreaterByPersonalID/{PID}', 'UserController@findCreaterByPersonalID');

Route::get('/findTeacher', 'UserController@findTeacher');

//--------------------------- GroupController ---------------------------

Route::get('/group','GroupController@group' );

Route::get('/addGroup', 'GroupController@ManageGroup');

Route::get('/Group/delete', 'GroupController@destroy');

Route::get('/Group/edit', 'GroupController@edit');

Route::get('/findAllGroup', 'GroupController@findAllGroup');

Route::get('/findMyGroup', 'GroupController@findMyGroup');

Route::get('/stdGroup', 'GroupController@stdGroup');

Route::get('/inGroup{id}', 'GroupController@inGroup');

Route::get('/teaInGroup{id}', 'GroupController@teaInGroup');

Route::get('/findGroupDataByID', 'GroupController@findGroupDataByID');

//--------------------------- SectionController ---------------------------

Route::get('/section/save', 'SectionController@store');

Route::get('/findAllSection', 'SectionController@findAllSection');

Route::get('/findMySection', 'SectionController@findMySection');

Route::get('/section/edit', 'SectionController@edit');

Route::get('/section/delete', 'SectionController@destroy');

//--------------------------- ExamController ---------------------------

Route::resource('/exam', 'ExamController');

Route::get('/findAllExam', 'ExamController@findAllExam');

Route::get('/checkExamByName', 'ExamController@checkExamByName');

Route::get('/addExam{id}', 'ExamController@create');

Route::get('/createTextFile', 'ExamController@createTextFile');

Route::post('/uploadFile', 'ExamController@uploadFile');

Route::get('/createExam', 'ExamController@store');

Route::get('/readFile', 'ExamController@readFile');

Route::get('/deleteExam/{id}', 'ExamController@destroy');

Route::get('/editExam{id}', 'ExamController@edit');

Route::get('/copyExam{id}', 'ExamController@copyExam');

Route::get('/findExamByID/{id}', 'ExamController@show');

Route::get('/updateExam', 'ExamController@update');

Route::get('/myExam', 'ExamController@myExam');

//--------------------------- ShareExamController ---------------------------

Route::get('/createSharedExam', 'ShareExamController@store');

Route::get('/findSharedUserNotMe', 'ShareExamController@findSharedUserNotMe');

Route::get('/deleteUserShared', 'ShareExamController@deleteUserShared');

Route::get('/updateSharedExam', 'ShareExamController@updateSharedExam');

Route::get('/findSectionSharedToMe', 'ShareExamController@findSectionSharedToMe');

Route::get('/findSectionSharedNotMe', 'ShareExamController@findSectionSharedNotMe');

Route::get('/findExamSharedToMe', 'ShareExamController@findExamSharedToMe');

//--------------------------- KeywordController ---------------------------

Route::get('/createKeyword', 'KeywordController@store');

Route::get('/findKeywordByEID', 'KeywordController@findKeywordByEID');

Route::get('/updateKeyword', 'KeywordController@update');

Route::get('/deleteKeyword', 'KeywordController@destroy');

//--------------------------- ExamingController ---------------------------

Route::get('/openExam', 'ExamingController@index');

Route::get('/createExaming', 'ExamingController@createExaming');

Route::get('/updateExaming', 'ExamingController@updateExaming');

Route::get('/findExamingByNameAndGroup', 'ExamingController@findExamingByNameAndGroup');

Route::get('/examingHistory', 'ExamingController@examingHistory');

Route::get('/findExamingByUserID', 'ExamingController@findExamingByUserID');

Route::get('/editOpenExam{id}', 'ExamingController@edit');

Route::get('/deleteExaming', 'ExamingController@destroy');

Route::get('/findExamingByID', 'ExamingController@findExamingByID');

Route::get('/findSTDExamingItsComing', 'ExamingController@findSTDExamingItsComing');

Route::get('/findExamingItsComing', 'ExamingController@findExamingItsComing');

Route::get('/changeHiddenExaming', 'ExamingController@changeHiddenExaming');

//--------------------------- ExamExamingController ---------------------------

Route::get('/createExamExaming', 'ExamExamingController@store');

Route::get('/updateExamExaming', 'ExamExamingController@update');

Route::get('/daleteExamExaming', 'ExamExamingController@destroy');

Route::get('/findExamExamingByExamingID', 'ExamExamingController@findExamExamingByExamingID');

//--------------------------- JoinGroupController ---------------------------

Route::get('/checkJoinGroup', 'JoinGroupController@checkJoinGroup');

Route::get('/createJoinGroup', 'JoinGroupController@store');

Route::get('/findMemberGroup', 'JoinGroupController@findMemberGroup');

Route::get('/exitGroup', 'JoinGroupController@exitGroup');

Route::get('/stdMyGroup', 'JoinGroupController@stdMyGroup');

Route::get('/findMyJoinGroup', 'JoinGroupController@findMyJoinGroup');