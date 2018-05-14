<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware(['auth:api', 'cors']);

Route::group(['middleware' => ['api','cors']], function () {

    Route::post('auth/register', 'Auth\ApiRegisterController@create');



});

Route::group(['middleware' => ['auth:api', 'cors']], function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('profile-edit', 'UserController@profileEdit');
    Route::post('profile-password-change', 'UserController@profilePasswordChange');
    Route::post('add', 'UserController@add');


    Route::group(['prefix'=>'get'], function () {
        Route::get('countries-list', 'ApiGetController@CountriesList');
        Route::get('user-post/{id}', 'ApiGetController@UserPostById');
        Route::get('user-posts', 'ApiGetController@UserPosts');
        Route::get('user-posts-markers', 'ApiGetController@UserPostsMarkers');
    });

    Route::group(['prefix'=>'post'], function () {
        Route::post('save-new-post', 'ApiPostController@SaveNewPost');
        Route::post('edit-post', 'ApiPostController@EditPost');
    });
    Route::group(['prefix'=>'delete'], function () {
        Route::delete('/user-post/{id}', 'ApiDeleteController@DeleteUserPost');
    });


});
