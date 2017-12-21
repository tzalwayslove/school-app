<?php

namespace App\Http\Controllers\Wx;

use App\Exceptions\LoginErrorException;
use App\Lib\Result;
use App\Model\Dom\YikatongLogin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class YikatongController extends Controller
{
    public function login(Request $request)
    {
        return view('wx.yikatong.login', compact('request'));
    }

    public function doLogin(Request $request)
    {
        $rules = [
            'code'=>'required',
            'user_name'=>'required',
            'password'=>'required'
        ];
        $message = [
            'code.required'=>'验证码必须填写',
            'user_name.required'=>'用户名必须填写',
            'password.required'=>'密码必须填写'
        ];

        $v = Validator::make($request->all(), $rules, $message);
        $v->validate();

        $code = $request->input('code');
        $user_name = $request->input('user_name');
        $password = $request->input('password');

        $yikatong = new YikatongLogin($user_name, $password);
        try{
            $yikatong->login($code);
            return [
                'result'=>new Result(true)
            ];
        }catch(LoginErrorException $e){
            return [
                'result'=>new Result(false, $e->getMessage())
            ];
        }
    }

    /**
     * 用来选择流水日期之类的
     * @param Request $request
     */
    public function index(Request $request)
    {


    }
}
