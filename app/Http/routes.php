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

Route::get('/findUserByID', 'UserController@findUserByID');

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

Route::post('/uploadFile/{path}', 'ExamController@uploadFile');

Route::get('/createExam', 'ExamController@store');

Route::get('/readFile', 'ExamController@readFile');

Route::get('/deleteExam/{id}', 'ExamController@destroy');

Route::get('/editExam{id}', 'ExamController@edit');

Route::get('/copyExam{id}', 'ExamController@copyExam');

Route::get('/findExamByID/{id}', 'ExamController@show');

Route::get('/updateExam', 'ExamController@update');

Route::get('/myExam', 'ExamController@myExam');

Route::get('/readExamContent', 'ExamController@readExamContent');

Route::get('/detailExam{id}', 'ExamController@detailExam');

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

Route::get('/findExamingItsEnding', 'ExamingController@findExamingItsEnding');

Route::get('/changeHiddenExaming', 'ExamingController@changeHiddenExaming');

Route::get('/changeHistoryExaming', 'ExamingController@changeHistoryExaming');

Route::get('/checkIP', 'ExamingController@checkIP');

Route::get('/viewExam{id}', 'ExamingController@viewExam');

Route::get('/pointBoard{id}', 'ExamingController@pointBoard');

Route::get('/assistPointBoard{id}', 'ExamingController@assistPointBoard');

//--------------------------- ExamExamingController ---------------------------

Route::get('/createExamExaming', 'ExamExamingController@store');

Route::get('/updateExamExaming', 'ExamExamingController@update');

Route::get('/daleteExamExaming', 'ExamExamingController@destroy');

Route::get('/findExamExamingByExamingID', 'ExamExamingController@findExamExamingByExamingID');

Route::get('/findExamExamingInViewExam', 'ExamExamingController@findExamExamingInViewExam');

//--------------------------- JoinGroupController ---------------------------

Route::get('/checkJoinGroup', 'JoinGroupController@checkJoinGroup');

Route::get('/createJoinGroup', 'JoinGroupController@store');

Route::get('/findMemberGroup', 'JoinGroupController@findMemberGroup');

Route::get('/exitGroup', 'JoinGroupController@exitGroup');

Route::get('/stdMyGroup', 'JoinGroupController@stdMyGroup');

Route::get('/findMyJoinGroup', 'JoinGroupController@findMyJoinGroup');

Route::get('/managePermissions', 'JoinGroupController@managePermissions');

Route::get('/findMyPermissionsInGroup', 'JoinGroupController@findMyPermissionsInGroup');

//--------------------------- WorkSheetController ---------------------------

Route::get('/myWorksheet','WorkSheetController@myWorksheet');

Route::get('/shareWorksheet','WorkSheetController@shareWorksheet');

Route::get('/addMyWorksheetGroup','WorkSheetController@addMyWorksheetGroup');

Route::get('/findMySheetGroup','WorkSheetController@findMySheetGroup');

Route::get('/delete/groupSheet','WorkSheetController@destroy');

Route::get('/edit/groupSheet','WorkSheetController@editSheetGroup');

Route::get('/addWorksheet{id}', 'WorkSheetController@addWorksheet');

Route::get('/findSheetByName', 'WorkSheetController@findSheetByName');

Route::get('/createWorksheet', 'WorkSheetController@createWorksheet');

Route::get('/updateWorksheet', 'WorkSheetController@updateWorksheet');

Route::post('/uploadFileSh/{path}', 'WorkSheetController@uploadFileSh');

Route::get('/findSheetByUserID', 'WorkSheetController@findSheetByUserID');

Route::get('/findSheetByID', 'WorkSheetController@findSheetByID');

Route::get('/createQuiz', 'WorkSheetController@createQuiz');

Route::get('/createSharedWorksheet', 'WorkSheetController@createSharedWorksheet');

Route::get('/editWorksheet{id}', 'WorkSheetController@editWorksheet');

Route::get('/copyWorksheet{id}', 'WorkSheetController@copyWorksheet');

Route::get('/findWorksheetByID{id}', 'WorkSheetController@findWorksheetByID');

Route::get('/readFileSh', 'WorkSheetController@readFileSh');

Route::get('/findSheetSharedUserNotMe', 'WorkSheetController@findSheetSharedUserNotMe');

Route::get('/deleteUserSharedSheet', 'WorkSheetController@deleteUserSharedSheet');

Route::get('/updateSharedSheet', 'WorkSheetController@updateSharedSheet');

Route::get('/updateQuiz', 'WorkSheetController@updateQuiz');

Route::get('/deleteQuiz', 'WorkSheetController@deleteQuiz');

Route::get('/deleteWorksheet{id}', 'WorkSheetController@deleteWorksheet');

Route::get('/findSheetGroupSharedNotMe', 'WorkSheetController@findSheetGroupSharedNotMe');

Route::get('/findSheetSharedToMe', 'WorkSheetController@findSheetSharedToMe');

Route::get('/readSheetTrial', 'WorkSheetController@readSheetTrial');

Route::get('/findQuizBySID','WorkSheetController@findQuizBySID');

//--------------------------- ExamRandomController ---------------------------

Route::get('/findExamRandomByUID','ExamRandomController@findExamRandomByUID');

Route::get('/addRandomExam/{examing_id}/{user_id}/{exam_id}','ExamRandomController@addRandomExam');

Route::get('/findExamRandomInViewExam','ExamRandomController@findExamRandomInViewExam');

//--------------------------- ResExamController ---------------------------

Route::post('/uploadExamFile/{EMID}/{EID}/{UID}','ResExamController@uploadExamFile');

Route::get('/checkQueueEx','ResExamController@checkQueueEx');

Route::get('/deleteFirstQueueEx','ResExamController@deleteFirstQueueEx');

Route::get('/findExamInScoreboard','ResExamController@examInScoreboard');

Route::get('/dataInScoreboard','ResExamController@dataInScoreboard');

Route::get('/editScore','ResExamController@editScore');

//--------------------------- ResSheetController ---------------------------

Route::post('/uploadSheetFile/{STID}/{SID}/{UID}','ResSheetController@uploadSheetFile');

Route::get('/checkQueueSh','ResSheetController@checkQueueSh');

Route::get('/deleteFirstQueueSh','ResSheetController@deleteFirstQueueSh');

//--------------------------- CompileJavaController ---------------------------

Route::post('/sendExamJava','CompileJavaController@sendExamJava');

Route::post('/sendSheetJava','CompileJavaController@sendSheetJava');

Route::get('/compileAndRunJava','CompileJavaController@compileAndRunJava');

Route::post('/test','CompileJavaController@test');

//--------------------------- CompileCController ---------------------------

Route::post('/sendExamC','CompileCController@sendExamC');

Route::get('/compileAndRunC','CompileCController@compileAndRunC');

Route::post('/sendSheetC','CompileCController@sendSheetC');

//--------------------------- CompileCppController ---------------------------

Route::post('/cppSendExam','CompileCppController@sendExamCpp');

Route::get('/cppCompileAndRun','CompileCppController@compileAndRunCpp');

Route::post('/cppSendSheet','CompileCppController@sendSheetCpp');

//--------------------------- PathExamController ---------------------------

Route::get('/findPathExamByResExamID','PathExamController@findPathExamByResExamID');

Route::get('/getCode','PathExamController@getCode');

Route::get('/readFileResRun','PathExamController@readFileResRun');

//--------------------------- SheetingController ---------------------------

Route::get('/openWorksheet','SheetingController@openWorksheet');

Route::get('/findSheetGroupSharedToMe','SheetingController@findSheetGroupSharedToMe');

Route::get('/findSheetingByNameAndGroup','SheetingController@findSheetingByNameAndGroup');

Route::get('/createSheeting','SheetingController@createSheeting');

Route::get('/createSheetSheeting','SheetingController@createSheetSheeting');

Route::get('/sheetingHistory','SheetingController@sheetingHistory');

Route::get('/findSheetingByUserID','SheetingController@findSheetingByUserID');

Route::get('/editOpenSheet{id}','SheetingController@editOpenSheet');

Route::get('/findSheetSheetingBySheetingID','SheetingController@findSheetSheetingBySheetingID');

Route::get('/findSheetSheetingInSheetBoard','SheetingController@findSheetSheetingInSheetBoard');

Route::get('/findSheetingByID','SheetingController@findSheetingByID');

Route::get('/updateSheeting','SheetingController@updateSheeting');

Route::get('/deleteSheetSheeting','SheetingController@deleteSheetSheeting');

Route::get('/updateSheetSheeting','SheetingController@updateSheetSheeting');

Route::get('/deleteSheeting','SheetingController@deleteSheeting');

Route::get('/findSheetingByGroupID','SheetingController@findSheetingByGroupID');

Route::get('/findSTDSheetingByGroupID','SheetingController@findSTDSheetingByGroupID');

Route::get('/viewSheet{id}','SheetingController@viewSheet');

Route::get('/findSheetSheetingInViewSheet','SheetingController@findSheetSheetingInViewSheet');

Route::get('/findOldCodeInResSheet','SheetingController@findOldCodeInResSheet');

Route::get('/sendQuiz','SheetingController@sendQuiz');

Route::get('/findResQuizByRSID','SheetingController@findResQuizByRSID');

Route::get('/changeHiddenSheeting','SheetingController@changeHiddenSheeting');

Route::get('/sheetBoard{id}','SheetingController@sheetBoard');

Route::get('/assistSheetBoard{id}','SheetingController@assistSheetBoard');

Route::get('/dataInSheetBoard','SheetingController@dataInSheetBoard');

Route::get('/findResSheetByID','SheetingController@findResSheetByID');

Route::get('/editTrialScore','SheetingController@editTrialScore');

Route::get('/editQuizScore','SheetingController@editQuizScore');

Route::get('/detailSheet{id}', 'SheetingController@detailSheet');