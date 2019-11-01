<?php


Route::group([

    // 'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::get('verify', 'AuthController@emailVerify');
});
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('jeff', 'AuthController@jeff');
    Route::get('closed', 'AuthController@closed');
});

Route::apiResources([
    'categories' => 'CategoryController',
    // 'posts' => 'PostController'
]);