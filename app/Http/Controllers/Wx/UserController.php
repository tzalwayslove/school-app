<?php

namespace App\Http\Controllers\Wx;

use App\Exceptions\LoginErrorException;
use App\Exceptions\userNotFountException;
use App\Lib\Result;
use App\Model\Dom\Chengji;
use App\Model\Dom\Kaochang;
use App\Model\Dom\Kechengbiao;
use App\Model\Dom\Pingjiao;
use App\Model\User;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //当前成绩
    public function chengji(Request $request)
    {
        $user = User::find(User::getId($request->input('user')));
        $xueqi = $request->input('xueqi', false);
        if (!$user) {
            return response([
                'result' => new Result(false, '未找到该用户@' . User::getId(User::getId($request->input('user'))))
            ]);
        }
        $login_name = $user->account;
        $password = $user->password;
        try {
            $chengji = new Chengji($login_name, $password);
            $res = $chengji->getChengji($xueqi);

            $this->getJidian($res);
            $data = [];
            foreach ($res as $item) {
                $data[] = $item;
            }

            return response([
                'result' => new Result($res),
                'chengji' => $data
            ]);

        } catch (RequestException $e) {
            return response([
                'result' => new Result(false, '请求校原网络超时或传输失败')
            ]);
        } catch(LoginErrorException $e){
            return response([
                'result' => new Result(false, $e->getMessage(), -2)
            ]);
        }catch (\Exception $e) {
            return response([
                'result' => new Result(false, $e->getMessage())
            ]);
        }

    }

    public function getJidian($res)
    {
        foreach ($res as $chengji) {
            if ($chengji->chengji >= 90 || strpos('优', $chengji->chengji) !== false) {
                $chengji->jidian = 4 ;
            } else if ($chengji->chengji >= 80 || strpos('良', $chengji->chengji)!== false || strpos('好', $chengji->chengji) !== false) {
                $chengji->jidian = 3;
            } else if ($chengji->chengji >= 70 || strpos('中', $chengji->chengji) !== false) {
                $chengji->jidian = 2;
            } else if ($chengji->chengji >= 60 || $chengji->chengji == '及格') {
                $chengji->jidian = 1;
            } else {
                $chengji->jidian = 0;
            }
        }
    }

    //全部成绩
    public function all(Request $request)
    {
        $user = User::find(User::getId($request->input('user')));

        if (!$user) {
            return response([
                'result' => new Result(false, '未找到该用户@' . User::getId($request->input('user')))
            ]);
        }
        $login_name = $user->account;
        $password = $user->password;

        try {
            $chengji = new Chengji($login_name, $password);
            $res = $chengji->all();
            $data = [];
            $this->getJidian($res);
            foreach ($res as $item) {
                $data[] = $item;
            }

            return response([
                'result' => new Result($res),
                'chengji' => $data
            ]);
        } catch (RequestException $e) {
            return response([
                'result' => new Result(false, '请求校原网络超时或传输失败')
            ]);
        } catch (\Exception $e) {
            return response([
                'result' => new Result(false, $e->getMessage()/* . $e->getFile() . $e->getLine()*/)
            ]);
        }
    }

    //课程表
    public function kecheng(Request $request)
    {
        $user = User::find(User::getId($request->input('user')));

        if (!$user) {
            return response([
                'result' => new Result(false, '未找到该用户!')
            ]);
        }

        $loginName = $user->account;
        $password = $user->password;

        try {
            $kecheng = new Kechengbiao($loginName, $password);
            $data = $kecheng->getTable($request->input('page'));
        } catch (RequestException $e) {
            return response([
                'result' => new Result(false, '请求校原网络超时或传输失败')
            ]);
        } catch (\Exception $e) {
            return response([
                'result' => new Result(false, $e->getMessage() . '!')
            ]);
        }
        return response([
            'result' => new Result(true),
            'data' => $data
        ]);
    }

    //考场
    public function kaochang(Request $request)
    {
        $user = User::find(User::getId($request->input('user')));
//        $user = session('user');
        if (!$user) {
            return response([
                'result' => new Result(false, '未找到该用户!')
            ]);
        }
        $loginName = $user->account;
        $password = $user->password;

        try {
            $kaochang = new Kaochang($loginName, $password);
            $data = $kaochang->getQueryData();
        } catch (RequestException $e) {
            return response([
                'result' => new Result(false, '请求校原网络超时或传输失败')
            ]);
        } catch (\Exception $e) {
            return response([
                'result' => new Result(false, $e->getMessage() . '!')
            ]);
        }
        $now = time();
        foreach ($data as $item) {
            $item_time = substr($item->shijian, 0, strpos($item->shijian, '~'));
            $item->finish = $now > strtotime($item_time);
        }
        return response([
            'result' => new Result(true),
            'kaochang' => $data
        ]);
    }

    public function pingjiaoView(Request $request)
    {
        $userId = $request->input('user');
        return view('wx.pingjiao.index', compact('userId'));
    }
    //一键评教
    public function pingjiao(Request $request)
    {
        try {
            $user = User::find(User::getId($request->input('user')));

            if (!$user) {
                throw new UserNotFountException('未找到该用户(uid):' . User::getId($request->input('user')));
            }

            $account = $user->account;
            $password = $user->password;

            if(!$account || !$password){
                throw  new \Exception('用户名或密码为空， 请绑定正确的账户');
            }

            $pingjiao = new Pingjiao($account, $password);
            $pingjiao->pingjiao();
            return [
                'result' => new Result(true)
            ];
        } catch (RequestException $e) {
            return response([
                'result' => new Result(false, '请求校原网络超时或传输失败')
            ]);
        } catch (\Exception $e) {
            return [
                'result' => new Result(false, $e->getMessage())
            ];
        }
    }

    //绑定
    public function bangding(Request $request)
    {
        $account = $request->input('account', false);
        $password = $request->input('password', false);

        if (!$account || !$password) {
            return response()->json([
                'result' => new Result(false, '用户名或密码不能为空')
            ]);
        }
        $user = session('local_user');

        User::where('account', $account)->update([
            'account' => '',
            'password' => ''
        ]);

        $user->account = $account;
        $user->passowrd = $password;
        $user->save();

        return response()->json([
            'result' => new Result(true)
        ]);
    }

    public function binding(Request $request)
    {
        $rules = [
            'account' => 'required',
            'password' => 'required'
        ];
        $message = [
            'account.required' => '账户必须填写!',
            'password.required' => '密码必须填写!'
        ];

        $v = Validator::make($request->all(), $rules, $message);
        $v->validate();

        $user = User::find(session('user')->id);

        $user->name = '';
        $user->id_card = '';
        $user->yikatong_password = '';
        $user->account = $request->input('account');
        $user->password = $request->input('password');
        $user->save();

        try{
            $user->getInfo();
        }catch(LoginErrorException $e){
            return [
                'result' => new Result(false, '用户名或密码错误', -2)
            ];
        }
        return [
            'result' => new Result(true)
        ];
    }

    public function getChengjiOptions(Request $request)
    {
        $user = User::find(User::getId($request->input('user')));
        if(!$user){
            return response()->json([
                'result'=>new Result(false, '请输入正确的id')
            ]);
        }

        try{
            $chengji = new Chengji($user->account, $user->password);
        }catch(LoginErrorException $e){
            return redirect('wx/binding?user='.$user->id);
        }
        return response()->json([
            'result'=>new Result(true),
            'options'=>$chengji->getOption()
        ]);
    }
}
