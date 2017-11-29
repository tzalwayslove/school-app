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

Route::get('admin', 'Admin\AdminController@index');

Route::resource('admin/category', 'Admin\CategoryController');
Route::resource('admin/posts', 'Admin\PostsController');
Route::resource('admin/pinpai', 'Admin\PinpaiController');
Route::resource('admin/chexing', 'Admin\ChexingController');

Route::get('test', function(){
    $a = null;
    return $a|0;
});

Route::post('upload', 'UploadController@index');
Route::delete('upload', 'UploadController@removeUpload');

Route::get('code', 'Admin\CodeController@index');
Route::post('code', 'Admin\CodeController@gettable');
Route::put('code', 'Admin\CodeController@settable');
