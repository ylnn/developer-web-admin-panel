<?php


Route::get('/', function () {
    return 'Mainpage';
});


Route::get('/manage', 'ManageController@index');

Route::get('/image/{h}/{w}/{filename}','ImageCacheController@show')
->where('h', '[0-9]+')
->where('w', '[0-9]+')
->where('filename', '[a-zA-Z0-9.]+')
;

// Auth::routes();

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');
