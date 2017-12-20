<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/20
 * Time: 9:31
 */
use EasyWeChat\Foundation\Application;

Route::get('/wechat', function(){
    echo $_GET['echostr'];
});