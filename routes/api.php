<?php

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('addEmployee', 'AuthController@refresh');
    
});

Route::apiResource('/employee','Api\EmployeeController');

Route::get('/pdf','PDFController@pdf');

Route::match(['get','post'],'/filterEmployee','Api\EmployeeController@filterEmployee');
Route::match(['get','post'],'/patientEmployee','Api\PatientController@filterEmployee');
Route::match(['get','post'],'/check_doctors_detail/{id}','Api\PatientController@check_doctors_detail');

Route::match(['get','post'],'saveInitialData','Api\PatientController@saveInitialData');
Route::match(['get','post'],'getPxInfo/{pspat}','Api\PatientController@getPxInfo');
Route::match(['get','post'],'getFormDetail/{id}','Api\PatientController@EditInitialData');



