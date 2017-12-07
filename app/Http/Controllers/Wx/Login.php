<?php

namespace App\Http\Controllers\Wx;

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
        return redirect(session('tar_get', url('/articel')));
    }
}
