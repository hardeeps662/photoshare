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





Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();
Route::get('/', 'FrontendController@index');
Route::get('/user-album/{id}', 'FrontendController@show');
Route::post('/follow-unfollow/{id}', 'FrontendController@followUnfollow');
Route::resource('/album', 'AlbumController');
Route::get('/getalbums', 'AlbumController@getAlbum');
Route::get('/images/{id}/create', 'ImagesController@create');
Route::get('/images/{id}', 'ImagesController@getImages');
Route::post('/images/{id}', 'ImagesController@store');
Route::post('/image/{id}/delete', 'ImagesController@delete');
Route::post('/image/{id}/delete', 'ImagesController@delete');
  /* comment routes  */
Route::get('/comment/{id}', 'CommentController@getComments');
Route::post('/comment/{id}', 'CommentController@store');
  /* reply routes  */
Route::get('/reply/{id}', 'replyController@getReply');
Route::post('/reply/{id}', 'ReplyController@store');
