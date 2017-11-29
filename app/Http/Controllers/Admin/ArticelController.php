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
        'user' => 'required|max:100',
        'cate' => 'required|max:100',
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
        return view('admin.articel.create');
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
        $data['show'] = isset($data['show']) ? 1 :0;
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
        return view('admin.articel.edit', compact('data'));
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
        $data['show'] = isset($data['show']) ? 1 :0;
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
