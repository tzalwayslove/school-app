<?php

namespace App\Model;

use App\Exceptions\userNotFountException;
use EasyWeChat\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Redis;


class User extends Model
{
    protected $table = 'user';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    use SoftDeletes;

    /**
     * @param $open_id
     * @param $user_id
     * @param $password
     */
    public static function bind($open_id, $message)
    {
        $ruser = Redis::get($open_id);

        $option = require 'wechatConfig.php';

        $app = new Application($option);
        $wx_user = $app->user->get($open_id);

        Log::log(json_encode($wx_user, JSON_UNESCAPED_UNICODE));

        if(!$ruser){
            throw new userNotFountException();
        }
        $ruserInfo = json_decode($ruser);
        if(!$ruser){
            throw new userNotFountException();
        }
        $ruserInfo->step = intval($ruserInfo->step);
        switch($ruserInfo->step){
            case 1:

                //输入了账户
                $ruserInfo->account = $message->Content;
                $ruserInfo->step = 2;

                Redis::set($open_id, json_encode($ruserInfo));
                Redis::expire ($open_id, 300);
                return '请输入密码:';
            case 2:
                //输入了密码
                $ruserInfo->password = $message->Content;
                $ruserInfo->step = 3;

                Redis::expire ($open_id, 0);

                self::updateOrCreate([
                    'open_id'=>$open_id
                ], [
                    'account'=>$ruserInfo->account,
                    'password'=>$ruserInfo->password,
                    'sex'=>$wx_user->sex,
                    'avatar'=>$wx_user->headimgurl,
                    'nick_name'=>$wx_user->nick_name
                ]);

                return '账户:'.$ruserInfo->account.'已保存';
            default:
                return 'default';
        }
    }

    public function binding($account, $password)
    {
        $this->account = $account;
        $this->password = $password;
        $this->save();
    }

    public static function createInit($uid)
    {
        Redis::set($uid, json_encode(['step'=>1]));
        Redis::expire ($uid, 300);
    }
    /**
     * 学号
     */
    public function account($account)
    {

    }
    /**
     * 密码
     */
    public function password()
    {

    }
}
