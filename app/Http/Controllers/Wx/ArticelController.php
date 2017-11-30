<?php

namespace App\Http\Controllers\Wx;

use App\Lib\Result;
use App\Model\Articel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticelController extends Controller
{
    public function index()
    {
        $list = Articel::paginate(20);
        return response(['result'=>new Result(true), 'list'=> $list]);
    }
}
