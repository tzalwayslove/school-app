<?php

namespace App\Http\Controllers\Admin;

use App\Lib\Result;
use App\Model\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    protected $validateRoule = [
        'content' => 'required|max:100',
        'articel' => 'required|exists:articel,id',
    ];

    public function index()
    {
        $list = \App\Model\Comment::with('getUser')->paginate(100);
        return view('admin.comment.index', compact('list'));
    }

    public function comment(Request $request, $id)
    {
        return response()->json(Comment::whereArticel($id)->with('getUser')->paginate(50));
    }

    public function editShow(Request $request)
    {
        $comment = Comment::find($request->input('id'));
        $comment->changeShow($request->input('show'));
        return ['result'=>new Result(true)];
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        $articel_ids = \App\Model\Articel::all();
        return view('admin.comment.create', compact('articel_ids'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $this->validate($request, $this->validateRoule);
        unset($data['uploadImg']);
        $data['show'] = isset($data['show']) ? 1 : 0;
        \App\Model\Comment::create($data);
        return redirect('admin/comment');
    }

    /**
     * Display the specified resource.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = \App\Model\Comment::findOrFail($id);
        $articel_ids = \App\Model\Articel::all();
        return view('admin.comment.edit', compact('data', 'articel_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request $request
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, $this->validateRoule);
        $data = $request->all();

        $data['show'] = isset($data['show']) ? 1 : 0;
        unset($data['uploadImg']);
        \App\Model\Comment::findOrFail($id)->update($data);
        return redirect('admin/comment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cate = \App\Model\Comment::findOrFail($id);
        $cate->delete();
        return response()->json([
            'status' => true
        ]);
    }
}
