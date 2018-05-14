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

Route::resource('tags','TagController');

Route::get('/test', function () {
    \Illuminate\Support\Facades\Log::emergency('hello world',['a' => 'b',]);
});

Route::view('/t', 'test')->name('t');

Route::any('/2', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Validator::make($request->all(), [
        'name' => [
            'required',
            'string',
            function ($attribute,$value,$fail) {
                if($value === 'foo'){
                    return $fail($attribute.' is invalid');
                }
            }
        ],
        'terms' => 'accepted',
    ])->validate();
    return $request->all();
});
