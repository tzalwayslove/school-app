<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::any('/wechat', 'Wx\IndexController@index');

Route::get('admin/comment/{id}', 'Admin\CommentController@comment');
Route::post('admin/comment/show', 'Admin\CommentController@editShow');

Route::get('minganci', function(){
    \App\Model\Articel::minganci('使用假、币 再加上我的自定义词汇');
});