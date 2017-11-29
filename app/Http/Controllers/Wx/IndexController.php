<?php

namespace App\Http\Controllers\Wx;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $option = require 'wechatConfig.php';

        $app = new Application($option);

        $server = $app->server;

        $server->setMessageHandler(function ($message) {
            // $message->FromUserName // 用户的 openid
            // $message->MsgType // 消息类型：event, text....
            return "您好！欢迎关注我!";
        });

        $response = $server->serve();
        return $response;
    }
}
