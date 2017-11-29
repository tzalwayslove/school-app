__template__

namespace App\Http\Controllers\Admin;

use App\Model\{{ $controller }};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class {{ $controller }}Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $validateRoule = [
        @foreach($col as $k=>$v)
            @if( in_array($v['col'], $time) || $v['col'] == 'id')
                @continue
                @endif
            @php
            switch($v['type']){
                case 'text':
                    echo "'{$v['col']}'=> 'required|max:100',\n";
                    break;
                case 'image':
                    echo "'{$v['col']}'=> 'required',\n";
                    break;
                case 'select':
                    if($v['from_table'] && $v['f_name']){
                        echo "'{$v['col']}'=> 'required|exists:{$v['from_table']},id'";
                    }
                    break;
            }
            @endphp
        @endforeach
    ];
    public function index()
    {
        $list = \App\Model\{{ $controller }}::paginate(100);
        return view('admin.{{ strtolower($controller) }}.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        @php
            $form = [];
        @endphp
        @foreach($col as $v)
            @if($v['type'] == 'select' && $v['from_table'] && $v['f_name'])
                ${{ $v['from_table'].'_'.$v['f_name'] }}s = \App\Model\{{ ucfirst($v['from_table']) }}::all();
                @php
                    $form[] = $v['from_table'].'_'.$v['f_name']."s";
                @endphp
            @endif
        @endforeach
        @php
            $str = implode("','", $form);
            $compact = $str ? ", compact('".$str."')": '';
        @endphp
        return view('admin.{{ strtolower($controller) }}.create' {!! $compact !!});
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $this->validate($request, $this->validateRoule);
        unset($data['uploadImg']);

        \App\Model\{{ $controller }}::create($data);
        return redirect('{{ strtolower('admin/'.$controller) }}');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = \App\Model\{{ $controller }}::findOrFail($id);
        @php
            $form = ['data'];
        @endphp
        @foreach($col as $v)
            @if($v['type'] == 'select' && $v['from_table'] && $v['f_name'])
                ${{ $v['from_table'].'_'.$v['f_name'] }}s = \App\Model\{{ ucfirst($v['from_table']) }}::all();
                @php
                    $form[] = $v['from_table'].'_'.$v['f_name']."s";
                @endphp
            @endif
        @endforeach
        @php
            $str = implode("','", $form);
            $compact = $str ? ", compact('".$str."')": '';
        @endphp
        return view('admin.{{ strtolower($controller) }}.edit'{!! $compact !!});
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, $this->validateRoule);
        $data = $request->all();

        unset($data['uploadImg']);
        \App\Model\{{ $controller }}::findOrFail($id)->update($data);
        return redirect('{{ strtolower('admin/'.$controller) }}');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cate = \App\Model\{{ $controller }}::findOrFail($id);
        $cate->delete();
        return response()->json([
            'status'=>true
        ]);
    }
}
