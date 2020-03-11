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
Route::get('/driver/archive', 'DriverController@archive');

Route::get('/list/accounts', 'AccountController@show');
Route::put('/list/account/black/{id}', 'AccountController@blackList')->middleware('auth');
Route::put('/list/account/unblack/{id}', 'AccountController@unlockedUser')->middleware('auth');

Route::get('/list/additives', 'AdditiveController@show');
Route::get('/list/categories', 'CategoryController@show');
Route::get('/list/types', 'TypeController@show');
Route::get('/list/ftypes', 'FoodTypeController@show');
Route::get('/list/fadditives', 'FoodAdditiveController@show');

Route::get('/list/foods', 'FoodController@show');
Route::put('/list/food/recomend/{id}', 'FoodController@recomend')->middleware('auth');
Route::put('/list/food/visibility/{id}', 'FoodController@visibility')->middleware('auth');

Route::get('/create/account', 'AccountController@index');
Route::get('/create/additive', 'AdditiveController@index');
Route::get('/create/category', 'CategoryController@index');
Route::get('/create/type', 'TypeController@index');
Route::get('/create/food', 'FoodController@index');
Route::get('/create/ftype', 'FoodTypeController@index');
Route::get('/create/fadditive', 'FoodAdditiveController@index');

Route::put('/edit/account/{id}', 'AccountController@edit')->middleware('auth');
Route::put('/edit/additive/{id}', 'AdditiveController@edit')->middleware('auth');
Route::put('/edit/category/{id}', 'CategoryController@edit')->middleware('auth');
Route::put('/edit/type/{id}', 'TypeController@edit')->middleware('auth');
Route::put('/edit/food/{id}', 'FoodController@edit')->middleware('auth');

Route::post('/store/account', 'AccountController@store')->middleware('auth');
Route::post('/store/additive', 'AdditiveController@store')->middleware('auth');
Route::post('/store/category', 'CategoryController@store')->middleware('auth');
Route::post('/store/type', 'TypeController@store')->middleware('auth');
Route::post('/store/food', 'FoodController@store')->middleware('auth');
Route::post('/store/ftype', 'FoodTypeController@store')->middleware('auth');
Route::post('/store/fadditive', 'FoodAdditiveController@store')->middleware('auth');

Route::put('/update/account/{id}', 'AccountController@update')->middleware('auth');
Route::put('/update/additive/{id}', 'AdditiveController@update')->middleware('auth');
Route::put('/update/category/{id}', 'CategoryController@update')->middleware('auth');
Route::put('/update/type/{id}', 'TypeController@update')->middleware('auth');
Route::put('/update/food/{id}', 'FoodController@update')->middleware('auth');
Route::put('/update/call/{id}', 'CallController@update')->middleware('auth');

Route::put('/delete/ftype/{id}/{type_id}', 'FoodTypeController@delete')->middleware('auth');
Route::put('/delete/fadditive/{id}', 'FoodAdditiveController@delete')->middleware('auth');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
