<?php

namespace App\Http\Controllers\Wx;

use App\Lib\Result;
use App\Model\Articel;
use App\Model\Comment;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $data = Articel::find($request->input('id'));

        $data->load(['getComment' => function ($query) {
            $query->where('show', 1)->orderBy('created_at', 'asc');
        }]);

        $data->_user_account = User::find($data->user);

        $data->load('getComment.getReply.getUser');
        $data->load('getComment.getUser');

        $data->click_count++;
        $data->save();

        foreach($data->getComment as $comment){
            $comment->get_reply = Comment::where('id', $comment->reply)->with('getUser')->first();
        }

        $data->_created_at = Articel::getTimeAgo($data->created_at->__toString());
        foreach ($data->getComment as $item) {
            $item->_created_at = Articel::getTimeAgo($item->created_at->__toString());
        }
        return response([
            'result',
            'data' => $data
        ]);
    }

    public function addComment(Request $request)
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

        $comment = Comment::addComment($articel, $content, $request->input('niming', false), $user);
        return response([
            'result' => new Result(true),
            'comment' => $comment
        ]);
    }

    public function zan(Request $request)
    {
        $comment = Comment::find($request->input('id'));
        if (!$comment) {
            return response(['result' => new Result(false, '未找到改文章')]);
        }
        $comment->zan += $request->input('zan');
        $comment->zan = $comment->zan < 0 ? 0 : $comment->zan;

        if ($comment->getUser) {
            $comment->getUser->zan += $request->input('zan');
            $comment->getUser->save();
        }

        $comment->save();
        return response(['result' => new Result(true), 'comment' => $comment]);
    }

    public function reply(Request $request)
    {
        $comment = Comment::find($request->input('comment'));
        $user = session('user');
        $content = $request->input('content');
        $niming = $request->input('niming');

        if (!$comment) {
            return response()->json([
                'result' => new Result(false, '未找到该评论!')
            ]);
        }

        if (!$content) {
            return response()->json([
                'result' => new Result(false, '评论内容不能为空')
            ]);
        }

        $com = new Comment();
        $com->articel = $comment->articel;
        $com->niming = $niming;
        $com->reply = $comment->id;
        $com->content = $content;
        $com->user = $user->id;
        $com->zan = 0;

        $com->save();
        return response()->json([
            'result' => new Result(true)
        ]);
    }
}
