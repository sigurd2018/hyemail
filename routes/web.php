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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/test-class', 'HomeController@testClass');

Route::get('/student', 'StudentController@index');

Route::get('/batch-inset-order', 'HomeController@batchInsertOrder');
Route::get('/random-update-order', 'HomeController@randomUpdateOrder');
Route::get('/get-order', 'HomeController@getOrder');
Route::get('/get-user-order', 'HomeController@getUserOrder');
Route::get('/batch-create-order-num', 'HomeController@batchCreateOrderNum');


Route::get('/mq-publish', 'MqPublisherController@index');