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

Route::get('/pastebin/create', 'PastebinController@create');
Route::get('/pastebin/show', 'PastebinController@show');
Route::post('/pastebin', 'PastebinController@save');
Route::post('/pastebin/{id}', 'PastebinController@update');
Route::get('/pastebin/view/{id}', 'PastebinController@view');
Route::get('/pastebin/edit/{id}', 'PastebinController@edit');
Route::get('/pastebin/delete/{id}', 'PastebinController@delete');

Route::view('/about', 'about');
Route::view('/contact', 'contact');