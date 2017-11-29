<?php

namespace App\Http\Controllers\Wx;

use App\Exceptions\userNotFountException;
use App\Model\Log;
use App\Model\User;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        try {
            $option = require 'wechatConfig.php';

            $app = new Application($option);

            $server = $app->server;
            try {
                $server->setMessageHandler(function ($message) use ($server) {
                    switch ($message->MsgType) {
                        case 'event':
                            return '收到事件消息';
                            break;
                        case 'text':
                            switch ($message->Content) {
                                case "绑定":
                                    User::createInit($message->FromUserName);
                                    return '请输入您的学号:';
                                default:
                                    try {
                                        $res = User::bind($message->FromUserName, $message);
                                        return $res;
                                    } catch (userNotFountException $e) {
                                        return '输入绑定即可进入绑定流程';
                                    }
                            }
//                        return json_encode($message, JSON_UNESCAPED_UNICODE);
                            break;
                        case 'image':
                            return '收到图片消息';
                            break;
                        case 'voice':
                            return '收到语音消息';
                            break;
                        case 'video':
                            return '收到视频消息';
                            break;
                        case 'location':
                            return '收到坐标消息';
                            break;
                        case 'link':
                            return '收到链接消息';
                            break;
                        // ... 其它消息
                        default:
                            return '收到其它消息';
                            break;
                    }
                });
            } catch (\Exception $e) {
                Log::log($e->getMessage() . $e->getFile() . $e->getLine());
            }
            $response = $server->serve();
            return $response;
        } catch (\Exception $e) {
            Log::log($e->getMessage() . $e->getFile() . $e->getLine());
        }
        return '';
    }
}
