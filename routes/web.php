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

Route::get('/dashboard', 'DashboardController@index');
Route::get('/control', 'ControlController@index');
Route::get('/calls', 'CallController@index');
Route::get('/calls/accepted', 'CallController@callsAccepted');

Route::get('/list/accounts', 'AccountController@show');
Route::put('/list/account/black/{id}', 'AccountController@blackList')->middleware('auth');
Route::put('/list/account/unblack/{id}', 'AccountController@unlockedUser')->middleware('auth');

Route::get('/create/account', 'AccountController@index');

Route::put('/edit/account/{id}', 'AccountController@edit')->middleware('auth');

Route::post('/store/account', 'AccountController@store')->middleware('auth');

Route::patch('/update/account', 'AccountController@update')->middleware('auth');
Route::put('/update/call/{id}', 'CallController@update')->middleware('auth');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
