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
    phpinfo();
});

Route::get('/s', function(){
    session(['a'=>10]);
});
Route::get('/g', function(){
    dd(session('a'));
});

Route::get('admin', 'Admin\AdminController@index');

Route::post('upload', 'UploadController@index');
Route::delete('upload', 'UploadController@removeUpload');

Route::get('code', 'Admin\CodeController@index');
Route::post('code', 'Admin\CodeController@gettable');
Route::put('code', 'Admin\CodeController@settable');

Route::get('test', function(){
    $res = \App\Model\User::firstOrCreate([
        'open_id'=>'ocDq7wTnH5dh9n09aNxRV0jrc05c'
    ], [
        'account'=>'123456',
        'password'=>'65464',
    ]);
});


Route::group([
    'prefix'=>'admin',
    'namespace'=> 'Admin'
], function(){
    Route::resource('user', 'UserController');
    Route::resource('cate', 'UserController');
});