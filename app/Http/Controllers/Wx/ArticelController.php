<?php

namespace App\Http\Controllers\Wx;

use App\Lib\Result;
use App\Model\Articel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticelController extends Controller
{
    public function index(Request $request)
    {

//        orderBy('click_count', 'desc')->orderBy('created_at', 'desc')
        if($request->input('click_count', false)){
            $list = Articel::orderBy('client_count', 'desc')->paginate(20);
        }else{
            $list = Articel::orderBy('created_at', 'desc')->paginate(20);
        }
        return response(['result'=>new Result(true), 'list'=> $list]);
    }

    public function store(Request $request)
    {
        $title = $request->input('title', false);
        $content = $request->input('content', false);

        if(!$title){
            return response(['result'=>new Result(false, '标题必须填写')]);
        }
        if(!$content){
            return response(['result'=>new Result(false, '内容必须填写')]);
        }

        Articel::newArticel($title, $content);

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
        $articel->save();
        return response(['result'=>new Result(true), 'articel'=>$articel]);
    }
}
