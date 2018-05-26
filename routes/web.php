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


Route::get('/image/{h}/{w}/{filename}','ImageCacheController@show')
->where('h', '[0-9]+')
->where('w', '[0-9]+')
->where('filename', '[a-zA-Z0-9.]+')
;
