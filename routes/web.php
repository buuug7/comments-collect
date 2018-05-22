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


// Post

Route::get('/contribute', function () {
    return view('contribute');
})->middleware('auth');

Route::post('/posts/{post}/star', 'PostController@star');
Route::get('/posts/{post}/comments', 'PostController@comments');
Route::resource('posts', 'PostController');

Route::resource('tags', 'TagController');

Route::post('/comments/{comment}/like', 'CommentController@like');
Route::post('/comments/{comment}/reply', 'CommentController@reply');
Route::resource('comments', 'CommentController');


// User

Route::post('/users/avatar', 'UserController@avatar');
Route::get('/users/profile', 'UserController@profile');
Route::put('/users/profile', 'UserController@updateProfile');

// Settings
Route::get('/settings/profile', function () {
    return view('settings.profile');
})->middleware('auth');


// Help

Route::get('/help/contribute-guide', function () {

    return view('help.contribute-guide');
});
