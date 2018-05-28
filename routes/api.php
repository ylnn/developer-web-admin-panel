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
    Route::get('portfolios/edit/{portfolio}', 'PortfolioController@edit');
    Route::post('portfolios/save/{portfolio}', 'PortfolioController@save');
    Route::delete('portfolios/delete/{portfolio}', 'PortfolioController@delete');

    Route::get('portfolios/images/{portfolio}', 'PortfolioController@images');
    Route::post('portfolios/images_sync/{portfolio}', 'PortfolioController@imageSync');

    Route::get('articles/all', 'ArticleController@all');
    Route::post('articles/create', 'ArticleController@create');
    Route::get('articles/edit/{id}', 'ArticleController@edit');
    Route::post('articles/save/{id}', 'ArticleController@save');
    Route::delete('articles/delete/{id}', 'ArticleController@delete');
    Route::get('articles/images/{portfolio}', 'ArticleController@images');
    Route::post('articles/images_sync/{portfolio}', 'ArticleController@imageSync');

    Route::get('images/all', 'ImageController@all');
    Route::post('images/save', 'ImageController@save');
    Route::delete('images/delete/{image}', 'ImageController@delete');

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
