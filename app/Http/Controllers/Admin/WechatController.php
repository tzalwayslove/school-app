<?php

namespace App\Http\Controllers\Admin;

use App\Model\Wechat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatController extends Controller
{
    public function index()
    {
        $list = Wechat::all();
        return view('admin.wechat.index', compact('list'));
    }

    public function set()
    {
        
    }
}
