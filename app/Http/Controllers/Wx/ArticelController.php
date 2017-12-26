<?php

namespace App\Http\Controllers\Wx;

use App\Lib\Result;
use App\Model\Articel;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ArticelController extends Controller
{
    public function index(Request $request)
    {
        if($request->input('click_count') == 1){
            $list = Articel::with('getComment')
                ->with('user_account')
                ->orderByRaw("DATE_FORMAT(created_at, '%Y-%m-%d') desc")
                ->orderBy('zan', 'desc')
                ->where('show', '1')
                ->paginate(20);
        }else{
            $list = Articel::with('getComment')
                ->with('user_account')
                ->orderBy('created_at', 'desc')
                ->orderBy('click_count', 'desc')
                ->where('show', '1')
                ->paginate(20);
        }
        dd($list);
        foreach($list as $item){
            $item->commentCount = count($item->getComment);
            $item->_created_at = Articel::getTimeAgo($item->created_at->__toString());
        }

        return response(['result'=>new Result(true), 'list'=> $list]);
    }

    public function store(Request $request)
    {
        $title = $request->input('title', false);
        $content = $request->input('content', false);
        $user = $request->input('user');

        if(!$content){
            return response(['result'=>new Result(false, '内容必须填写')]);
        }

        Articel::newArticel($title, $content, 0, $request->input('niming', false));

        return response(['result'=>new Result(true)]);

    }

    public function zan(Request $request)
    {
        $articel = Articel::find($request->input('id'));
        if(!$articel){
            return response(['result'=>new Result(false, '未找到改文章')]);
        }
        $articel->zan += $request->input('zan');
        $articel->zan  = $articel->zan < 0 ? 0 : $articel->zan;

        if($articel->user_account){
            $articel->user_account->zan += $request->input('zan');
            $articel->user_account->save();
        }

        $articel->save();
        return response(['result'=>new Result(true), 'articel'=>$articel]);
    }
}
