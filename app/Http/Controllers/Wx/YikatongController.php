<?php

namespace App\Http\Controllers\Wx;

use App\Model\Dom\YikatongLogin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class YikatongController extends Controller
{
    public function login()
    {
        return view('wx.yikatong.login');
    }

    public function index(Request $request)
    {
        $yikatong = new YikatongLogin('lkjflsdkfjl', 'lksdjflksdfj');
        $code = $request->input('code');

        $yikatong->login($code);

    }
}