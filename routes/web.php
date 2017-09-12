<?php

Route::get('/', function () {

    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('threads', 'ThreadsController', ['except' => ['index', 'show']]);

Route::get('threads/{channel}/{thread}', 'ThreadsController@show')->name('threads.show');

Route::get('threads/{channel?}', 'ThreadsController@index')->name('threads.index');

//Route::resource('threads', 'ThreadController');

Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');

Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
