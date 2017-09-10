<?php

Route::get('/', function () {

    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/threads', 'ThreadsController@index');

Route::get('/threads/{thread}', 'ThreadsController@show');

Route::post('/threads', 'ThreadsController@store');

Route::post('/threads/{thread}/replies', 'RepliesController@store');
