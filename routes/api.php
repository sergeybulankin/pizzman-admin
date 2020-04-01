<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('selected-all-statuses', 'StatusController@index');
Route::post('selected-orders', 'OrderController@index');
Route::get('selected-calls', 'CallController@countCalls');
Route::post('selected-orders-by-status', 'OrderController@selectOrderByStatus');
Route::post('selected-list-food', 'OrderController@listFood');
Route::post('view-driver', 'OrderController@viewDriver');
Route::get('selected-all-drivers', 'AccountController@selectDrivers');
Route::post('transition-to-a-new-stage', 'OrderController@nextStage');
Route::post('send-order-to-courier', 'OrderController@sendOrderToCourier');
Route::post('selected-orders-for-driver', 'DriverController@index');
Route::post('count-active-orders', 'DriverController@countOrders');
Route::post('order-delivered', 'DriverController@orderDelivered');
Route::post('info-for-user', 'AccountController@account');
Route::post('info-for-user-point', 'AccountController@accountPoint');