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
    'coupons'=>'CouponController',
    'products'=>'ProductController'

    // 'posts' => 'PostController'
]);
Route::get('slug/{slug}','ProductController@slug');
Route::get('products/category/{id}','ProductController@category');
Route::get('products/type/{id}','ProductController@type');

//Middleware with login restrictions
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('jeff', 'AuthController@jeff');
    Route::get('closed', 'AuthController@closed');

    //Only admins will be able to access this routes
    Route::group(['middleware'=>'checkadmin'], function(){
       Route::apiResource('coupon', 'CouponController')->except('show');
       Route::apiResource('products', 'ProductController', ['only'=>['store', 'update', 'destroy']]);
       Route::apiResource('categories', 'CategoryController', ['only'=>['store', 'update', 'destroy']]);
       Route::apiResource('types', 'TypeController', ['only'=>['store', 'update', 'destroy']]);
       Route::apiResource('sub-categories', 'SubCategoryController', ['only'=>['store', 'update', 'destroy']]);
        //Route::resource('properties', 'PropertyController');
    });


});

