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

Route::get('/threads', 'ThreadsController@index')->name('home');
Route::get('/threads/create', 'ThreadsController@create');
Route::post('/threads', 'ThreadsController@store');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy');
Route::get('/threads/{channel}', 'ThreadsController@index');
Route::patch('/threads/{thread}', 'ThreadsController@update');
Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');

Route::patch('/replies/{reply}', 'RepliesController@update')->name('replies.update');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.delete');
Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');

Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->middleware('auth');


Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile.get');
Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index')->name('profile.notifications.index');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy')->name('profile.notifications.delete');
