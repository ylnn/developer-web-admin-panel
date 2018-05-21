<?php
use Illuminate\Http\Request;


Route::get('/', function (Request $request) {
    return 'hello!';
});

Route::group(['prefix' => 'manage', 'namespace' => 'Admin'], function () {
    
    Route::get('variables/all', 'VarController@all');
    Route::post('variables/create', 'VarController@create');
    Route::get('variables/edit/{variable}', 'VarController@edit');
    Route::post('variables/save/{variable}', 'VarController@save');
    Route::delete('variables/delete/{variable}', 'VarController@delete');


    Route::get('portfolios/all', 'PortfolioController@all');
    Route::post('portfolios/create', 'PortfolioController@create');
    Route::get('portfolios/edit/{variable}', 'PortfolioController@edit');
    Route::post('portfolios/save/{variable}', 'PortfolioController@save');
    Route::delete('portfolios/delete/{variable}', 'PortfolioController@delete');

    Route::get('articles/all', function () {});
    Route::post('articles/create', function () {});
    Route::get('articles/edit/{id}', function () {});
    Route::post('articles/save/{id}', function () {});
    Route::delete('articles/delete/{id}', function () {});

    Route::get('images/all', function () {});
    Route::post('images/save', function () {});
    Route::delete('images/delete/{id}', function () {});

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
