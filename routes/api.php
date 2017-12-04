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

Route::get('loginTest', function(){
//    \App\Model\Dom\Login::login();
//    dd($_SERVER);
    $Login = new \App\Model\Dom\Login('201637025002', 'liuxuemin123');
    $str = $Login->getPage('/xsd/kscj/cjcx_query');

    echo $str;
});

/*Route::get('chengji', function(){
    $chengji = new \App\Model\Dom\Chengji('201637025002', 'liuxuemin1234');
    $list = $chengji->getChengji();

    dd($list);
});*/
Route::any('api/test', function(){
    echo file_get_contents('php://input');
    echo '<pre>';

    foreach ($_SERVER as $name => $value)
    {
        if (substr($name, 0, 5) == 'HTTP_')
        {
            $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
        }
    }
    print_r($headers);
    dd($_POST);
});

Route::get('chengji', 'Wx\UserController@nowChengji');
Route::get('chengji_all', 'Wx\UserController@all');