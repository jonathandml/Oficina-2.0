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

use App\Http\Controllers\EstimatesController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if(Auth::check()){
        return redirect('/orcamentos');
    }
    return redirect('login');
    
});

Auth::routes();

Route::get('/orcamentos','EstimatesController@index');
Route::get('/orcamentos/create','EstimatesController@create');
Route::get('orcamentos/{estimate}/edit','EstimatesController@edit');
Route::get('orcamentos/{estimate}','EstimatesController@show');
Route::post('/orcamentos','EstimatesController@store');
Route::patch('orcamentos/{estimate}','EstimatesController@update');
Route::delete('orcamentos/{estimate}','EstimatesController@destroy')->name('estimate.destroy');

Route::get('/search','EstimatesController@search');