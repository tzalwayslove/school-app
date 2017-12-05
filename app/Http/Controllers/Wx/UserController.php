<?php

namespace App\Http\Controllers\Wx;

use App\Lib\Result;
use App\Model\Dom\Chengji;
use App\Model\Dom\Kechengbiao;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function nowChengji(Request $request)
    {

        $user = User::find($request->input('user'));
        if(!$user){
            return response([
                'result'=>new Result(false, '未找到该用户@'.$request->input('user'))
            ]);
        }
        $login_name = $user->account;
        $password = $user->password;
        try{

            $chengji = new Chengji($login_name, $password);
            $res = $chengji->getChengji();

            return response([
                'result'=>new Result($res),
                'chengji'=>$res
            ]);

        }catch(\Exception $e){
            return response([
                'result'=>new Result(false, $e->getMessage(). $e->getFile(). $e->getLine())
            ]);
        }

    }

    public function all(Request $request)
    {

        $user = User::find($request->input('user'));
        if(!$user){
            return response([
                'result'=>new Result(false, '未找到该用户@'.$request->input('user'))
            ]);
        }
        $login_name = $user->account;
        $password = $user->password;

        try{
            $chengji = new Chengji($login_name, $password);
            $res = $chengji->all();

            return response([
                'result'=>new Result($res),
                'chengji'=>$res
            ]);

        }catch(\Exception $e){
            return response([
                'result'=>new Result(false, $e->getMessage(). $e->getFile(). $e->getLine())
            ]);
        }

    }

    public function kecheng(Request $request)
    {
        $user = User::find($request->input('user'));
        if(!$user){
            return response([
                'result'=>new Result(false, '未找到该用户!')
            ]);
        }
        $loginName = $user->account;
        $password = $user->password;
        $kecheng = new Kechengbiao($loginName, $password);
        $table = $kecheng->getTable();
        return response([
            'result'=>new Result(true),
            'table'=>$table
        ]);
    }
}
