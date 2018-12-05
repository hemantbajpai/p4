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

Route::get('/', 'WelcomeController');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/pastebin/create', 'PastebinController@create');
    Route::post('/pastebin', 'PastebinController@store');

    Route::get('/pastebin', 'PastebinController@index');
    Route::get('/pastebin/{id}', 'PastebinController@show');

    Route::get('/pastebin/{id}/edit', 'PastebinController@edit');
    Route::put('/pastebin/{id}', 'PastebinController@update');

    Route::get('/pastebin/delete/{id}', 'PastebinController@delete');
});

Route::view('/about', 'about');
Route::view('/contact', 'contact');
Auth::routes();

