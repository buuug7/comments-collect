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

// User
Route::view('/my/posts', 'users.my-posts')->middleware('auth');
Route::view('/my/posts/star', 'users.my-posts-star')->middleware('auth');
Route::view('/my/comments', 'users.my-comments')->middleware('auth');
Route::view('/my/comments/liked', 'users.my-comments-liked')->middleware('auth');
Route::view('/my/notifications', 'users.my-notifications');


Route::get('/people/{email}', function ($email) {
    return view('users.index', ['email' => $email,]);
});

// Settings
Route::view('/settings/profile', 'settings.profile')->middleware('auth');
Route::view('/settings/developer', 'settings.developer')->middleware('auth');


// Help
Route::get('/help/contribute-guide', function () {
    return view('help.contribute-guide');
});

// UI
Route::view('/ui/common', 'ui.common');
Route::view('/ui/headline', 'ui.headline');
Route::view('/ui/user-widget', 'ui.user-widget');


