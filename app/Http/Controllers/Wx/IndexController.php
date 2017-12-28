<?php

namespace App\Http\Controllers\Wx;

use App\Exceptions\userNotFountException;
use App\Lib\Chengji;
use App\Model\Log;
use App\Model\User;
use App\Model\Wechat;
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
                            $user = User::whereOpenId($message->FromUserName)->first();
                            if (!$user) {
                                $user = User::storeUser($message->FromUserName);
                                return '您还没有绑定过账号!请输入<a href="' . url('wx/binding/?user=' . $user->id) . '">‘绑定’</a>进行绑定操作。';
                            }
                            switch ($message->EventKey) {
                                case '最新成绩':

                                    return sprintf(Wechat::getOne('event', '最新成绩'), $user->id);
                                case "全部成绩":
                                    return sprintf(Wechat::getOne('event', '全部成绩'), $user->id);
                                case '本周课程表':
                                    return sprintf(Wechat::getOne('event', '本周课程表'), $user->id);
                                case '全部课程表':
                                    return sprintf(Wechat::getOne('event', '全部课程表'), $user->id);
                                case '考场':
                                    return sprintf(Wechat::getOne('event', '考场'), $user->id);
                            }
                            break;
                        case 'text':
                            if (strpos($message->Content, '绑定') !== false) {
                                $user = User::storeUser($message->FromUserName);
                                return sprintf(Wechat::getOne('text', '绑定'), $user->id);
                            } else if (strpos($message->Content, '考场') !== false) {
                                $user = User::whereOpenId($message->FromUserName)->first();
                                if (!$user) {
                                    $user = User::storeUser($message->FromUserName);
                                    Log::log(sprintf(Wechat::getOne('event', '考场'), $user->id));
                                    return sprintf(Wechat::getOne('default', '没有绑定的回复'), $user->id);
                                }
                                return sprintf(Wechat::getOne('text', '考场'), $user->id);
                            } else if (strpos($message->Content, '课表') !== false || strpos($message->Content, '课程表') !== false) {
                                $user = User::whereOpenId($message->FromUserName)->first();
                                if (!$user) {
                                    $user = User::storeUser($message->FromUserName);
                                    return sprintf(Wechat::getOne('default', '没有绑定的回复'), $user->id);
                                }
                                return sprintf(Wechat::getOne('text', '课表'), $user->id);
                            } else if (strpos($message->Content, '成绩') !== false) {
                                $user = User::whereOpenId($message->FromUserName)->first();
                                if (!$user) {
                                    $user = User::storeUser($message->FromUserName);
                                    return sprintf(Wechat::getOne('default', '没有绑定的回复'), $user->id);
                                }
//                                return '成绩： <a href="' . url('/wx/chengji?user=' . $user->id) . '">成绩</a>';
                                return sprintf(Wechat::getOne('text', '成绩'), $user->id);
                            } else if (strpos($message->Content, '评教') !== false) {
                                $user = User::whereOpenId($message->FromUserName)->first();
                                if (!$user) {
                                    $user = User::storeUser($message->FromUserName);
                                    return sprintf(Wechat::getOne('default', '没有绑定的回复'), $user->id);
                                }

                                return sprintf(Wechat::getOne('text', '一键评教'), $user->id);
                            }else if (strpos($message->Content, '社区') !== false) {
                                $user = User::whereOpenId($message->FromUserName)->first();
                                if (!$user) {
                                    $user = User::storeUser($message->FromUserName);
                                    return sprintf(Wechat::getOne('default', '没有绑定的回复'), $user->id);
                                }
                                return sprintf(Wechat::getOne('text', '社区'), $user->id);

                            } else if($message->Content == '忘记密码'){
                                return sprintf(Wechat::getOne('text', '忘记密码'));
                            } else if($message->Content == '一卡通'){
                                $user = User::whereOpenId($message->FromUserName)->first();
                                if (!$user) {
                                    $user = User::storeUser($message->FromUserName);
                                    return sprintf(Wechat::getOne('default', '没有绑定的回复'), $user->id);
                                }
                                return sprintf(Wechat::getOne('text', '一卡通'));
                            }else {
//                                try {
//                                    $res = User::bind($message->FromUserName, $message);
//                                    return $res;
//                                } catch (userNotFountException $e) {
//                                    return '输入绑定即可进入绑定流程';
//                                }
                                return '输入绑定， 进行绑定操作';
                            }
                            break;
                        case 'image':
                            return 'i';
                            break;
                        case 'voice':
                            return 'vo';
                            break;
                        case 'video':
                            return 'vi';
                            break;
                        case 'location':
                            return 'lo';
                            break;
                        case 'link':
                            return 'li';
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
