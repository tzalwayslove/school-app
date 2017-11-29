<?php

namespace App\Http\Controllers\Admin;

use App\Model\Cate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    protected $validateRoule = [
        'name' => 'required|max:100',
    ];

    public function index()
    {
        $list = \App\Model\Cate::paginate(100);
        return view('admin.cate.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cate.create');
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
        \App\Model\Cate::create($data);
        return redirect('admin/cate');
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
        $data = \App\Model\Cate::findOrFail($id);
        return view('admin.cate.edit', compact('data'));
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
        \App\Model\Cate::findOrFail($id)->update($data);
        return redirect('admin/cate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cate = \App\Model\Cate::findOrFail($id);
        $cate->delete();
        return response()->json([
            'status' => true
        ]);
    }
}
