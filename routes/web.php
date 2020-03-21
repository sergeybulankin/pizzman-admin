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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/dashboard', 'DashboardController@index');
Route::get('/control', 'ControlController@index');
Route::get('/calls', 'CallController@index');
Route::get('/calls/accepted', 'CallController@callsAccepted');
Route::get('/statistics', 'StatisticController@index');
Route::get('/driver/archive', 'DriverController@archive');
Route::get('/statistics', 'StatisticController@index');
Route::post('/statistics/dates', 'StatisticController@betweenDates');

Route::group(['prefix' => 'list'], function () {
    Route::get('/accounts', 'AccountController@show');
    Route::put('/account/black/{id}', 'AccountController@blackList')->middleware('auth');
    Route::put('/account/unblack/{id}', 'AccountController@unlockedUser')->middleware('auth');

    Route::get('/additives', 'AdditiveController@show');
    Route::get('/categories', 'CategoryController@show');
    Route::get('/types', 'TypeController@show');
    Route::get('/ftypes', 'FoodTypeController@show');
    Route::get('/fadditives', 'FoodAdditiveController@show');

    Route::get('/foods', 'FoodController@show');
    Route::put('/food/recomend/{id}', 'FoodController@recomend')->middleware('auth');
    Route::put('/food/visibility/{id}', 'FoodController@visibility')->middleware('auth');
});

Route::group(['prefix' => 'create'], function() {
    Route::get('/account', 'AccountController@index');
    Route::get('/additive', 'AdditiveController@index');
    Route::get('/category', 'CategoryController@index');
    Route::get('/type', 'TypeController@index');
    Route::get('/food', 'FoodController@index');
    Route::get('/ftype', 'FoodTypeController@index');
    Route::get('/fadditive', 'FoodAdditiveController@index');
});

Route::group(['prefix' => 'edit'], function() {
    Route::put('/account/{id}', 'AccountController@edit')->middleware('auth');
    Route::put('/additive/{id}', 'AdditiveController@edit')->middleware('auth');
    Route::put('/category/{id}', 'CategoryController@edit')->middleware('auth');
    Route::put('/type/{id}', 'TypeController@edit')->middleware('auth');
    Route::put('/food/{id}', 'FoodController@edit')->middleware('auth');
    Route::get('/user/{id}', 'AccountController@editAccount')->middleware('auth');
});

Route::group(['prefix' => 'store'], function() {
    Route::post('/account', 'AccountController@store')->middleware('auth');
    Route::post('/additive', 'AdditiveController@store')->middleware('auth');
    Route::post('/category', 'CategoryController@store')->middleware('auth');
    Route::post('/type', 'TypeController@store')->middleware('auth');
    Route::post('/food', 'FoodController@store')->middleware('auth');
    Route::post('/ftype', 'FoodTypeController@store')->middleware('auth');
    Route::post('/fadditive', 'FoodAdditiveController@store')->middleware('auth');
});

Route::group(['prefix' => 'update'], function() {
    Route::put('/account/{id}', 'AccountController@update')->middleware('auth');
    Route::put('/additive/{id}', 'AdditiveController@update')->middleware('auth');
    Route::put('/category/{id}', 'CategoryController@update')->middleware('auth');
    Route::put('/type/{id}', 'TypeController@update')->middleware('auth');
    Route::put('/food/{id}', 'FoodController@update')->middleware('auth');
    Route::put('/call/{id}', 'CallController@update')->middleware('auth');
    Route::put('/user/{id}', 'AccountController@updateAccount')->middleware('auth');
});

Route::group(['prefix' => 'delete'], function() {
    Route::put('/ftype/{id}/{type_id}', 'FoodTypeController@delete')->middleware('auth');
    Route::put('/fadditive/{id}', 'FoodAdditiveController@delete')->middleware('auth');
});
