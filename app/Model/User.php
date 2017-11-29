<?php

namespace App\Model;

use App\Exceptions\userNotFountException;
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
                return 2;
                $ruserInfo->password = $message->Content;
                $ruserInfo->step = 3;

                Redis::set($open_id, json_encode($ruserInfo));
                Redis::expire ($open_id, 300);

                $user = self::createOrUpdate([
                    'open_id'=>$open_id
                ], [
                    'account'=>$ruserInfo['account'],
                    'password'=>$ruserInfo['password'],
                ]);
                return '账户:'.$ruserInfo['account'].'已保存';

                break;
            default:
                return 'default';
        }
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
