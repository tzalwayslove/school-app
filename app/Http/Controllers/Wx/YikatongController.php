<?php

namespace App\Http\Controllers\Wx;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class YikatongController extends Controller
{
    public function login()
    {
        return view('wx.yikatong.login');
    }
}
