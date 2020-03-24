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

Route::apiResources([
    'categories' => 'CategoryController',
    'types'=>'TypeController',
    'sub-categories'=>'SubCategoryController',
    'roles'=>'RoleController',
    'coupon'=>'CouponController'

    // 'posts' => 'PostController'
]);


//Middleware with login restrictions
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('jeff', 'AuthController@jeff');
    Route::get('closed', 'AuthController@closed');

    //Only admins will be able to access this routes
    Route::group(['middleware'=>'checkadmin'], function(){
       Route::apiResource('coupon', 'CouponController');
        //Route::resource('properties', 'PropertyController');
    });


});

