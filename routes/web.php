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
Route::get('/show', 'PostController@show')->name('show');

Route::get('/api','ApiTestController@test');
Route::get('/calender','ApiTestController@calender')->name('calender');
Route::get('/google_calendar','ApiTestController@google_calendar')->name('google_calendar');
