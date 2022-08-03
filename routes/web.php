<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/welcome', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function (){
    Route::middleware('admin')->group(function (){
        Route::get('/update/user/{id}', 'PostController@showUpdateUser');
        Route::get('/users', 'PostController@showUsers');
        Route::post('/updating/user', 'PostController@updateUser');
    });

    Route::middleware('editor')->group(function (){
        Route::get('/reports', 'PostController@showReports');
        Route::get('/delete/report/{id}', 'PostController@deleteReport');
        Route::get('/delete/post/{id}', 'PostController@deletePost');
        Route::get('/update/post/{id}', 'PostController@showUpdatePost');
        Route::get('/restore/post/{id}', 'PostController@restorePost');
        Route::post('/updating/post', 'PostController@updatePost');
    });

    Route::middleware('moderator')->group(function (){
        Route::get('/reports', 'PostController@showReports');
        Route::get('/delete/report/{id}', 'PostController@deleteReport');
        Route::get('/delete/comment/{id}', 'PostController@deleteComment');
        Route::get('/delete/image/{id}', 'ImageController@deleteImage');
    });

    Route::middleware('author')->group(function (){
        Route::get('/addpost', 'PostController@showAddPost');
        Route::post('/adding/post', 'PostController@addPost');
    });

    Route::middleware('commentator')->group(function (){
        Route::post('/adding/comment', 'PostController@addComment');
    });

    Route::post('/adding/avatar/', 'ImageController@addingAvatar');
    Route::get('/add/avatar/', 'ImageController@showAddAvatar');
    Route::get('/delete/avatar/', 'ImageController@deleteAvatar');
    Route::get('/post/{id}', 'PostController@showPost');
    Route::get('/images/{id}', 'ImageController@imageUpload');
    Route::post('/adding/image', 'ImageController@imageUploadPost');
    Route::get('/user/{id}', 'PostController@showProfile');
    Route::get('/like/{type}/{id}/{user_id?}/{dislike?}', 'PostController@addLike');
    Route::get('/logout', 'AuthController@logout');
    Route::get('/add/report/{type}/{id}', 'PostController@showAddReport');
    Route::post('/adding/report', 'PostController@addReport');
});

Route::get('/posts', 'PostController@showPosts');
Route::get('/', function () { return redirect('/posts'); });

Route::get('/login', 'AuthController@showLogin')->name('login');
Route::get('/register', 'AuthController@showRegister');
Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');



//test
Route::get('/session', 'PostController@session');
Route::middleware('auth')->get('/editor', function() {
    return View::make('layouts.postEditor');
});
