<?php

namespace App\Http\Controllers\Wx;

use App\Model\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function index(Request $request, $id)
    {
        $comments = Comment::whereArticel($id)->where('show', 1)->get();
        return response([
            'result',
            'list'=>$comments
        ]);
    }
}
