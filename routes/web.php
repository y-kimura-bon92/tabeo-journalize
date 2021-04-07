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

Route::get('/','CalendarController@index')->name('index');
Route::get('/recording/{id}','CalendarController@getRecordingId')->name('getRecordingId');
Route::get('/recording', 'CalendarController@getRecording')->name('getRecording');
Route::post('/recording', 'CalendarController@postRecording')->name('postRecording');
Route::delete('/recording','CalendarController@deleteRecording')->name('deleteRecording');
Route::get('/datails/{id}', 'CalendarController@getDatails')->name('getDatails');
Route::post('/update', 'CalendarController@postUpdate')->name('postUpdate');

Route::get('business_card', 'BusinessCardController@index');
Route::post('business_card/extract', 'BusinessCardController@extract');

Route::get('/show', 'PostController@show')->name('show');

Route::get('/api','ApiTestController@test');
Route::get('/calender','ApiTestController@calender')->name('calender');
Route::get('/google_calendar','ApiTestController@google_calendar')->name('google_calendar');
Route::get('/sample','ApiTestController@sample')->name('sample');
