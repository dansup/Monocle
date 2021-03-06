<?php

// Monocle application routes
Route::domain(parse_url(env('APP_URL'), PHP_URL_HOST))->group(function(){
  Route::middleware('web')->group(function(){
    Route::get('/', function() {
      return view('welcome');
    })->name('index');

    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

    Route::post('/channel/new', 'HomeController@create_channel')->name('create_channel');
    Route::get('/channel/{channel}', 'HomeController@channel')->name('channel');
    Route::post('/channel/{channel}/save', 'HomeController@save_channel')->name('save_channel');
    Route::post('/channel/{channel}/delete', 'HomeController@delete_channel')->name('delete_channel');
    Route::post('/channel/{channel}/add_source', 'HomeController@add_source')->name('add_source');
    Route::post('/channel/{channel}/remove_source', 'HomeController@remove_source')->name('remove_source');
    Route::post('/channel/{channel}/add_apikey', 'HomeController@add_apikey')->name('add_apikey');

    Route::post('/source/find_feeds', 'HomeController@find_feeds')->name('find_feeds');

    Route::get('/login', 'LoginController@login')->name('login');
    Route::get('/logout', 'LoginController@logout')->name('logout');
    Route::post('/login', 'LoginController@start');
    Route::get('/login/callback', 'LoginController@callback')->name('login_callback');
  });
});

// Catch-all for all other domains mapped
Route::get('/', 'HostedController@index');
