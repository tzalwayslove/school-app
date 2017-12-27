<?php

namespace App\Http\Controllers\Wx;

use App\Exceptions\userNotFountException;
use App\Lib\Chengji;
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
                            $user = User::whereOpenId($message->FromUserName)->first();
                            if (!$user) {
                                $user = User::storeUser($message->FromUserName);
                                return '您还没有绑定过账号!请输入<a href="' . url('wx/binding/?user=' . $user->id) . '">‘绑定’</a>进行绑定操作。';
                            }
                            switch ($message->EventKey) {
                                case '最新成绩':
                                    return '<a href="' . url('/wx/chengji?user=' . $user->id) . '">最新成绩</a> ';
                                case "全部成绩":
                                    return '<a href="' . url('/wx/chengji_all?user=' . $user->id) . '">全部成绩</a>';
                                case '本周课程表':
                                    return '<a href="' . url('/wx/kecheng?user=' . $user->id . '&all=0') . '">本周课表</a>';
                                case '全部课程表':
                                    return '<a href="' . url('/wx/kecheng?user=' . $user->id . '&all=1') . '">全部课程表</a>';
                                case '考场':
                                    return '<a href="' . url('/wx/kaochang?user=' . $user->id) . '">考场</a>';
                            }
                            break;
                        case 'text':
                            if (strpos($message->Content, '绑定') !== false) {
                                /*User::createInit($message->FromUserName);
                                return '请输入您的学号:';*/
                                $user = User::storeUser($message->FromUserName);
                                return '点击<a href="' . url('wx/binding/?user=' . $user->id) . '">‘绑定’</a>进行绑定操作。';
                            } else if (strpos($message->Content, '考场') !== false) {
                                $user = User::whereOpenId($message->FromUserName)->first();
                                if (!$user) {
                                    $user = User::storeUser($message->FromUserName);
                                    return '您还没有绑定过账号!请输入<a href="' . url('wx/binding/?user=' . $user->id) . '">‘绑定’</a>进行绑定操作。';
                                }
                                return '考场： <a href="' . url('/wx/kaochang?user=' . $user->id) . '">考场</a>';
                            } else if (strpos($message->Content, '课表') !== false || strpos($message->Content, '课程表') !== false) {
                                $user = User::whereOpenId($message->FromUserName)->first();
                                if (!$user) {
                                    $user = User::storeUser($message->FromUserName);
                                    return '您还没有绑定过账号!请输入<a href="' . url('wx/binding/?user=' . $user->id) . '">‘绑定’</a>进行绑定操作。';
                                }
                                return '课程表： <a href="' . url('/wx/kecheng?user=' . $user->id . '&all=0') . '">课程表</a>';
                            } else if (strpos($message->Content, '成绩') !== false) {
                                $user = User::whereOpenId($message->FromUserName)->first();
                                if (!$user) {
                                    $user = User::storeUser($message->FromUserName);
                                    return '您还没有绑定过账号!请输入<a href="' . url('wx/binding/?user=' . $user->id) . '">‘绑定’</a>进行绑定操作。';
                                }
                                return '成绩： <a href="' . url('/wx/chengji?user=' . $user->id) . '">成绩</a>';
                            } else if (strpos($message->Content, '评教') !== false) {
                                $user = User::whereOpenId($message->FromUserName)->first();
                                if (!$user) {
                                    $user = User::storeUser($message->FromUserName);
                                    return '您还没有绑定过账号!请输入<a href="' . url('wx/binding/?user=' . $user->id) . '">‘绑定’</a>进行绑定操作。';
                                }

                                return '一键评教： <a href="' . url('/wx/pingjiao?user=' . $user->id) . '">一键评教</a>';
                            }else if (strpos($message->Content, '社区') !== false) {
                                $user = User::whereOpenId($message->FromUserName)->first();
                                if (!$user) {
                                    $user = User::storeUser($message->FromUserName);
                                    return '您还没有绑定过账号!请输入<a href="' . url('wx/binding/?user=' . $user->id) . '">‘绑定’</a>进行绑定操作。';
                                }

                                return '匿名社区： <a href="' . url('/?user='.$user->id.'#/tiezi') . '">匿名社区</a>';
                            } else if($message->Content == '忘记密码'){
                                return '<a href="http://jwgld.hrbcu.edu.cn/framework/enteraccount.jsp">忘记密码</a>';
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
