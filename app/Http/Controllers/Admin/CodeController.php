<?php

namespace App\Http\Controllers\Admin;

use App\Model\Code;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class CodeController extends Controller
{
    public function index()
    {
        return view('admin.code.index');
    }

    public function gettable(Request $request)
    {
        $this->validate($request, [
            'table' => 'required'
        ]);

        $table = $request->input('table');

        $col = $this->getField($table);

        foreach ($col as $k => $v) {
            if (is_array($v['default'])) {
                $map = [];
                foreach ($v['default'] as $defKey => $defVal) {
                    $map[] = $defKey . ":" . $defVal;
                }
                $col[$k]['default'] = implode(',', $map);
            }
        }

        $type = [
            'text',     //文本
            'textarea',//多行文本
            'f_textarea',//富文本
            'hidden',//隐藏域
            'checkbox',//复选框
            'select',//下拉框
            'radio',//单选框
            'date',//日期
            'dateTime',//日期时间
            'image',//图片
            'number'
        ];

        return view('admin.code.gettable', compact('col', 'type', 'table'));
    }

    private function getField($table)
    {
        $col = Schema::getColumnListing($table);

        $data = Code::where(['table' => $table])->get();

        $list = [];
        foreach ($col as $k => $v) {
            $list[$k]['col'] = $v;
            $list[$k]['alias'] = $this->getInfo($data, $v, 'alias');
            $list[$k]['type'] = $this->getInfo($data, $v, 'type');
            $list[$k]['index'] = $this->getInfo($data, $v, 'index') !== "" ? $this->getInfo($data, $v, 'index') : 1;
            $list[$k]['add'] = $this->getInfo($data, $v, 'add') !== "" ? $this->getInfo($data, $v, 'add') : 1;
            $list[$k]['edit'] = $this->getInfo($data, $v, 'edit') !== "" ? $this->getInfo($data, $v, 'edit') : 1;
            $list[$k]['default'] = $this->getInfo($data, $v, 'default');
            $list[$k]['from_table'] = $this->getInfo($data, $v, 'from_table');
            $list[$k]['f_name'] = $this->getInfo($data, $v, 'f_name');

        }

        foreach ($list as $k => $v) {
            if (!$v['default']) {
                continue;
            }
            //数组
            if (is_string($v['default'])) {
                $list[$k]['default'] = trim($v['default']);
            }

            if ($exp = explode(',', $v['default'])) {
                $default = [];
                foreach ($exp as $key => $value) {
                    if ($data = explode(':', $value)) {
                        $default[$data[0]] = $data[1];
                    }
                }
                $list[$k]['default'] = $default;
            }
        }
        return $list;
    }

    private function getInfo($data, $field, $info)
    {

        if (!$data) {
            return "";
        }
        foreach ($data as $k => $v) {
            if ($v->col == $field) {
                return $v->$info;
            }
        }

        return "";
    }

    public function settable(Request $request)
    {
        $table = $request->input('table');

        foreach ($request->input('field') as $k => $v) {
            Code::updateOrCreate(
                ['table' => $table, 'col' => $v['col']],
                [
                    'table' => $table,
                    'alias' => $v['alias'] ? $v['alias'] : '',
                    'type' => $v['type'] ? $v['type'] : '',
                    'index' => isset($v['index']) ? 1 : 0,
                    'add' => isset($v['add']) ? 1 : 0,
                    'edit' => isset($v['edit']) ? 1 : 0,
                    'default' => $v['default'] ? $v['default'] : '',
                    'from_table' => $v['from_table'] ? $v['from_table'] : '',
                    'f_name' => $v['f_name'] ? $v['f_name'] : '',
                ]
            );
        }
        $col = $this->getField($table);


        $this->createController($table, $col);
        $this->createModel($table, $col);
        $this->createIndex($table, $col);
        $this->createAdd($table, $col);
        $this->createEdit($table, $col);
        return redirect('code');
    }

    private function createController($table, $col)
    {
        $time = ['created_at', 'updated_at', 'deleted_at'];
        $controller = ucfirst($table);
        $template = view('admin.code.templateController', compact('col', 'time', 'controller'))->__toString();
        $template = str_replace('__template__', '<?php', $template);

        file_put_contents('./app/Http/Controllers/Admin/' . $controller . 'Controller.php', $template);
    }

    private function createModel($table, $col)
    {
        $time = ['created_at', 'updated_at', 'deleted_at'];
        $model = ucfirst($table);

        $template = view('admin.code.templateModel', compact('col', 'time', 'model'))->__toString();
        $template = str_replace('__template__', '<?php', $template);

        file_put_contents('./app/Model/' . $model . '.php', $template);
    }

    private function createIndex($table, $col)
    {
        $time = ['created_at', 'updated_at', 'deleted_at'];
        $controller = ucfirst($table);


        $foreach = "@foreach";
        $endforeach = "@endforeach";

        $if = "@if";
        $endif = "@endif";

        $extend = "@extends";

        $section = "@section";
        $endsection = "@endsection";

        $push = "@push";
        $endpush = "@endpush";

        $l = "{{ ";
        $r = " }}";

        $k = '{{ $k->';

        $template = view('admin.code.templateIndex', compact(
            'controller',
            'col',
            'time',
            'model',
            'foreach',
            'endforeach',
            'if',
            'endif',
            'extend',
            'section',
            'endsection',
            'push',
            'endpush',
            'k',
            'l',
            'r'
        ))->__toString();
        $template = str_replace('__template__', '<?php', $template);


        $dir = './resources/views/admin/' . $controller;
        if (!is_dir($dir)) {
            mkdir($dir, 777, true);
        }

        file_put_contents('./resources/views/admin/' . $controller . '/index.blade.php', $template);
    }

    private function createAdd($table, $col)
    {
        $controller = ucfirst($table);

        $l = '{{ ';
        $r = ' }}';
        $template = view('admin.code.templateCreate', compact('col', 'controller', 'l', 'r'))->__toString();
        $template = str_replace('__template__', '<?php', $template);

        $dir = './resources/views/admin/' . $controller;
        if (!is_dir($dir)) {
            mkdir($dir, 777, true);
        }
        file_put_contents('./resources/views/admin/' . $controller . '/create.blade.php', $template);
    }

    private function createEdit($table, $col)
    {
        $controller = ucfirst($table);

        $l = '{{ ';
        $r = ' }}';
        $template = view('admin.code.templateEdit', compact('col', 'controller', 'l', 'r'))->__toString();
        $template = str_replace('__template__', '<?php', $template);

        $dir = './resources/views/admin/' . $controller;
        if (!is_dir($dir)) {
            mkdir($dir, 777, true);
        }
        file_put_contents('./resources/views/admin/' . $controller . '/edit.blade.php', $template);
    }
}
