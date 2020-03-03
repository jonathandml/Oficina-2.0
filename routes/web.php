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

Route::get('/orcamentos','EstimatesController@index');
Route::get('/orcamentos/create','EstimatesController@create');
Route::post('/orcamentos','EstimatesController@store');
Route::get('orcamentos/{estimate}','EstimatesController@show');

Route::get('/search','EstimatesController@search');