<?php

namespace App\Http\Controllers;

use App\Model\Log;
use Illuminate\Http\Request;

class WeChatController extends Controller
{
    public function serve()
    {
        Log::log('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $app = app('wechat.official_account');
        $app->server->push(function($message){
            return "欢迎关注 overtrue！";
        });

        return $app->server->serve();
    }
}
