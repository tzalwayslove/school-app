<?php

namespace App\Http\Controllers\Admin;

use App\Model\Articel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ArticelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    protected $validateRoule = [
        'zan' => 'required|max:100',
        'user' => 'required|exists:user,id',
        'cate'=> 'required|exists:cate,id'
    ];
    public function index()
    {
        $list = \App\Model\Articel::paginate(100);
        return view('admin.articel.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        $user_accounts = \App\Model\User::all();
        $cate_names = \App\Model\Cate::all();
        return view('admin.articel.create', compact('user_accounts', 'cate_names'));
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
        $data['show'] = isset($data['show']) ? 1 : 0 ;
        \App\Model\Articel::create($data);
        return redirect('admin/articel');
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
        $data = \App\Model\Articel::findOrFail($id);
        $user_accounts = \App\Model\User::all();
        $cate_names = \App\Model\Cate::all();
        return view('admin.articel.edit', compact('data', 'user_accounts', 'cate_names'));
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

        $data['show'] = isset($data['show']) ? 1 : 0 ;
        unset($data['uploadImg']);
        \App\Model\Articel::findOrFail($id)->update($data);
        return redirect('admin/articel');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cate = \App\Model\Articel::findOrFail($id);
        $cate->delete();
        return response()->json([
            'status' => true
        ]);
    }
}
