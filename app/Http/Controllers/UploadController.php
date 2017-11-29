<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function index(Request $request)
    {

        $this->validate($request, [
            'uploadImg' => 'required|file|image|max:2000',
        ]);

        $path = $request->file('uploadImg')->store('upload');
        return response()->json([
            'status'=>true,
            'path'=>$path
        ]);
    }

    public function removeUpload(Request $request)
    {
        $this->validate($request, [
            'path' => 'required'
        ]);

        Storage::delete($request->input('path'));
        return response()->json([
            'status'=>true,
        ]);
    }
}
