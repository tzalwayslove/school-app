<?php

namespace App\Http\Controllers\Wx;

use App\Exceptions\LoginErrorException;
use App\Exceptions\noAccountException;
use App\Lib\Liushui;
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
                'result'=>new Result(true),
                'target'=>session('target')
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
        return view('wx.yikatong.index', compact('request'));
    }

    public function queryList(Request $request)
    {
        return \App\Model\Dom\Liushui::getSelectDate();
    }
    public function getData(Request $request)
    {
        $query = \App\Model\Dom\Liushui::getSelectDate();
        $start_time = $request->input('start_time', $query['threeDaysAgo']['start_time']);
        $end_time = $request->input('end_time', $query['threeDaysAgo']['end_time']);
        $page = $request->input('page', 1);

        $user = session('user');
        $liushui = new \App\Model\Dom\Liushui($user->account, '123456');

        try{
            $res = $liushui->getData($start_time, $end_time, $page);

            $data = [];
            foreach($res['data'] as $item){
                $data[] = $item;
            }

            $res['data'] = $data;
            return [
                'result'=>new Result(true),
                'liushui'=>$res
            ];

        } catch(LoginErrorException $e){
            return [
                'result'=>new Result(false, $e->getMessage(), -2)
            ];
        } catch(noAccountException $e){
            return [
                'result'=>new Result(false, '登录过期，请重新登录', -2)
            ];
        }catch(\Exception $e){
            return [
                'result'=>new Result(false, $e->getMessage())
            ];
        }
    }

    /**
     * 重新登录
     */
    public function reLogin(Request $request)
    {
        session(['isLogin'=>false]);
        return back();
    }
}
