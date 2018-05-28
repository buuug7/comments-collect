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
Route::post('/posts/{post}/star', 'PostController@star');
Route::post('/posts/{post}/comments', 'PostController@comments');
Route::resource('posts', 'PostController');

Route::view('/contribute', 'contribute')->middleware('auth');

// Comments
Route::post('/comments/{comment}/like', 'CommentController@like');
Route::post('/comments/{comment}/reply', 'CommentController@reply');
Route::resource('comments', 'CommentController');

// Notifications
Route::post('/notifications/{id}/read','NotificationController@markAsRead');

// Tags
Route::resource('tags', 'TagController');


// User
Route::post('/users/avatar', 'UserController@avatar');
Route::post('/users/profile', 'UserController@profile');
Route::put('/users/profile', 'UserController@updateProfile');
Route::post('/users/posts','UserController@posts');
Route::post('/users/posts/star','UserController@starPosts');
Route::post('/users/comments','UserController@comments');
Route::post('/users/comments/liked','UserController@likedComments');
Route::post('/users/notifications','UserController@notifications');


Route::view('/users/my/posts','users.my-posts')->middleware('auth');
Route::view('/users/my/posts/star','users.my-posts-star')->middleware('auth');
Route::view('/users/my/comments','users.my-comments')->middleware('auth');
Route::view('/users/my/comments/liked','users.my-comments-liked')->middleware('auth');
Route::view('/users/my/notifications','users.my-notifications');


// Settings
Route::view('/settings/profile', 'settings.profile')->middleware('auth');


// Help
Route::get('/help/contribute-guide', function () {
    return view('help.contribute-guide');
});

// UI
Route::view('/ui/common','ui.common');
Route::view('/ui/headline','ui.headline');
Route::view('/ui/user-widget','ui.user-widget');


// Test
Route::get('/test',function (\Illuminate\Http\Request $request){
    //return $request->user()->unreadNotifyCount();
});

