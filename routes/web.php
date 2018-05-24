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

Auth::routes();

Route::get('/', function () {
    return redirect('home');
});

Route::get('/home', 'HomeController@index')->name('home');


// Posts
Route::view('/contribute', 'contribute')->middleware('auth');

Route::post('/posts/{post}/star', 'PostController@star');
Route::get('/posts/{post}/comments', 'PostController@comments');
Route::resource('posts', 'PostController');

// Comments
Route::post('/comments/{comment}/like', 'CommentController@like');
Route::post('/comments/{comment}/reply', 'CommentController@reply');
Route::resource('comments', 'CommentController');


// Tags
Route::resource('tags', 'TagController');


// User
Route::post('/users/avatar', 'UserController@avatar');
Route::get('/users/profile', 'UserController@profile');
Route::put('/users/profile', 'UserController@updateProfile');
Route::get('/users/posts','UserController@posts');
Route::get('/users/posts/star','UserController@starPosts');
Route::get('/users/comments','UserController@comments');
Route::get('/users/comments/liked','UserController@likedComments');

Route::view('/users/my/posts','users.my-posts')->middleware('auth');
Route::view('/users/my/posts/star','users.my-posts-star')->middleware('auth');
Route::view('/users/my/comments','users.my-comments')->middleware('auth');
Route::view('/users/my/comments/liked','users.my-comments-liked')->middleware('auth');


// Settings
Route::get('/settings/profile', function () {
    return view('settings.profile');
})->middleware('auth');


// Help
Route::get('/help/contribute-guide', function () {
    return view('help.contribute-guide');
});

// UI
Route::view('/ui/common','ui.common');
Route::view('/ui/headline','ui.headline');


// Test
Route::get('/test',function (){
    \App\Jobs\TestJob::dispatch()->delay(now()->addSecond(5));
});

