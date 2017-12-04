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

use EasyWeChat\Foundation\Application;

Route::get('/', function () {
    return view('wx.index');
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
    dd(\App\Model\User::whereOpinId('ocDq7wTnH5dh9n09aNxRV0jrc05c')->find());
});

Route::group([
    'prefix'=>'admin',
    'namespace'=> 'Admin'
], function(){
    Route::resource('user', 'UserController');
    Route::resource('cate', 'CateController');
    Route::resource('articel', 'ArticelController');
    Route::resource('comment', 'CommentController');
});


Route::group([
    'prefix'=>'wx',
    'namespace'=> 'Wx'
], function(){
    Route::get('/articel', 'ArticelController@index');
    Route::get('/comment/{id}', 'CommentController@index');
    Route::post('/articel', 'ArticelController@store');
    Route::post('/articel_zan', 'ArticelController@zan');
    Route::post('/comment_zan', 'CommentController@zan');
    Route::post('/addComment', 'CommentController@addComment');

    Route::get('/chengji', function (\Illuminate\Http\Request $request) {
        return view('wx.chengji.index')->withUser($request->input('user'));
    });
});
Route::get('wx_menu', function(){
    $option = require 'wechatConfig.php';

    $app = new Application($option);
    $menu = $app->menu;
    $buttons = [
        [
            "type" => "click",
            "name" => "考试成绩",
            "key"  => "chengji"
        ],
        /*[
            "name"       => "菜单",
            "sub_button" => [
                [
                    "type" => "view",
                    "name" => "搜索",
                    "url"  => "http://www.soso.com/"
                ],
                [
                    "type" => "view",
                    "name" => "视频",
                    "url"  => "http://v.qq.com/"
                ],
                [
                    "type" => "click",
                    "name" => "赞一下我们",
                    "key" => "V1001_GOOD"
                ],
            ],
        ],*/
    ];
    $menu->add($buttons);

});