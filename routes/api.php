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

//
// Tags
//
Route::resource('tags', 'API\TagController');

//
// Post
//
Route::get('/posts', 'API\PostController@index');
Route::post('/posts', 'API\PostController@store');
Route::get('/posts/{post}', 'API\PostController@show');
Route::put('/posts/{post}', 'API\PostController@update');
Route::delete('/posts/{post}', 'API\PostController@destroy');

Route::post('/posts/{post}/star', 'API\PostController@star');
Route::get('/posts/{post}/comments', 'API\PostController@comments');

//
// Comment
//
Route::get('/comments', 'API\CommentController@index');
Route::post('/comments', 'API\CommentController@store');
Route::get('/comments/{comment}', 'API\CommentController@show');
Route::put('/comments/{comment}', 'API\CommentController@update');
Route::delete('/comments/{comment}', 'API\CommentController@destory');

Route::post('/comments/{comment}/like', 'API\CommentController@like');
Route::post('/comments/{comment}/reply', 'API\CommentController@reply');

//
// Notifications
//
Route::post('/notifications/{id}/read', 'API\NotificationController@markAsRead');


//
// User
//
Route::get('/users','API\UserController@index');

Route::get('/users/{email}', 'API\UserController@show');

Route::post('/user/avatar', 'API\UserController@avatar');

Route::put('/user/profile', 'API\UserController@profile');

Route::get('/user/posts', 'API\UserController@posts');

Route::get('/user/posts/star', 'API\UserController@starPosts');

Route::get('/user/comments', 'API\UserController@comments');

Route::get('/user/comments/liked', 'API\UserController@likedComments');

Route::get('/user/notifications', 'API\UserController@notifications');