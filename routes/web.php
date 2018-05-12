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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('posts', 'PostController');

Route::view('/t', 'test');

Route::post('/test', function (\Illuminate\Http\Request $request) {
    dd($request->file('avatar')->store('public/avatars'));
});

Route::get('/away',function(){
    return response()->download('storage/avatars/iVLOAZDh39KQ7K5nV9uJQwaImeRmpibMvvI3AGkM.jpeg','avatar.jpg');
});
