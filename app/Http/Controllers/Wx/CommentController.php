<?php

namespace App\Http\Controllers\Wx;

use App\Lib\Result;
use App\Model\Articel;
use App\Model\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function index(Request $request, $id)
    {

//        $comments = Comment::whereArticel($id)->where('show', 1)->get();
        $data = Articel::find($id);
        $data->load(['getComment'=> function($query){
            $query->where('show', 1)->orderBy('created_at', 'asc');
        }]);

        return response([
            'result',
            'data'=>$data
        ]);
    }

    public function addComment(Request $request)
    {
        $articel = Articel::find($request->input('id'));
        if(!$articel){
            return response([
                'result'=> new Result(false, '未找到该文章')
            ]);
        }

        $content = $request->input('content', false);
        if(!$content){
            return response([
                'result'=> new Result(false, '评论内容不能为空!')
            ]);
        }

        $comment = Comment::addComment($articel, $content);
        return response([
            'result'=> new Result(true),
            'comment' => $comment
        ]);
    }
}
