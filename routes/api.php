<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('selected-all-statuses', 'StatusController@index');
Route::get('selected-orders', 'OrderController@index');
Route::post('selected-orders-by-status', 'OrderController@selectOrderByStatus');
Route::get('selected-all-drivers', 'AccountController@selectDrivers');
Route::post('transition-to-a-new-stage', 'OrderController@nextStage');
Route::post('send-order-to-courier', 'OrderController@sendOrderToCourier');