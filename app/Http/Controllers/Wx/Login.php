<?php

namespace App\Http\Controllers\Wx;

use App\Model\User;
use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Login extends Controller
{
    public function index(Request $request)
    {
        $config = include('wechatConfig.php');
        $app = new Application($config);
        $user = $app->oauth->user();
        session(['wx_user'=>$user]);
        dd($user);
        $local_user = User::firstOrCreate([
            'open_id'=>$user->id
        ], [
            'account'=>'',
            'password'=>'',
            'name'=>'',
            'nick_name'=>$user->nickname,
            'avatar'=>$user->avatar,
            'sex'=>$user->original['sex']
        ]);
        session(['user'=>$local_user]);

        return redirect(session('tar_get', url('/articel')));
    }
}
