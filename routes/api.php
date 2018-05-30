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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//
// Post
//
Route::get('/posts', 'API\PostController@index');
Route::post('/posts', 'API\PostController@store');
Route::get('/posts/{post}', 'API\PostController@show');
Route::put('/posts/{post}', 'API\PostController@update');
Route::delete('/posts/{post}', 'API\PostController@destory');

Route::post('/posts/{post}/star', 'API\PostController@star');
Route::get('/posts/{post}/comments', 'API\PostController@comments');

//
// Comment
//
Route::get('/comments','API\CommentController@index');
Route::post('/comments','API\CommentController@store');
Route::get('/comments/{comment}','API\CommentController@show');
Route::put('/comments/{comment}','API\CommentController@update');
Route::delete('/comments/{comment}','API\CommentController@destory');

Route::post('/comments/{comment}/like', 'API\CommentController@like');
Route::post('/comments/{comment}/reply', 'API\CommentController@reply');


//
// User
//

