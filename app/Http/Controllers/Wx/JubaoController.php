<?php

namespace App\Http\Controllers\Wx;

use App\Lib\Result;
use App\Model\Articel;
use App\Model\Comment;
use App\Model\Jubao;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JubaoController extends Controller
{

    public function jubao(Request $request)
    {
        $articel = Articel::find($request->input('articel'));
        $user = session('user');

        if (!$articel) {
            return response([
                'result' => new Result(false, '未找到该文章')
            ]);
        }

        $content = $request->input('content', false);
        if (!$content) {
            return response([
                'result' => new Result(false, '评论内容不能为空!')
            ]);
        }

        $jubao = new Jubao();
        $jubao->content = $content;
        $jubao->user = $user->id;
        $jubao->articel = $articel->id;
        $jubao->save();

        if(Jubao::where('articel',$articel->id )->count() >= 5 ){
            $articel->show = 0;
            $articel->save();
        }
        return response([
            'result' => new Result(true)
        ]);
    }
}
