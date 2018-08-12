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

/**
 * Dashboard
 */
Route::get('/', 'DashboardController@index');

/**
 * Subscriber
 */
Route::post('/subscriber', 'SubscriberController@store');
Route::get('/subscribers/sendWindLimitNotifications', 'SubscriberController@sendWindLimitNotifications');
