<?php

namespace App\Http\Controllers\Wx;

use App\Lib\Result;
use App\Model\Articel;
use App\Model\Comment;
use App\Model\Jubao;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{

    public function addJubao(Request $request)
    {
        $articel = Articel::find($request->input('id'));
        $user = $request->input('user');
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

//        $comment = Comment::addComment($articel, $content, $request->input('niming', false), $user);
        $jubao = new Jubao();
        $jubao->content = $content;
        $jubao->user = $user;
        $jubao->articel = $articel->id;
        $jubao->save();
        return response([
            'result' => new Result(true)
        ]);
    }
}
