@extends('layout.admin')

@section('right_col')
    <div class="right_col">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Code</h3>
                </div>
                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <div class="input-group">
                            <button class="btn btn-danger" type="submit" form="form">生成</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div id="table" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                <div class="col-sm-12">
                                    <form action="{{ url('code') }}" method="post" id="form">
                                        {{ csrf_field() }}
                                        {{ method_field('put') }}
                                        <input type="hidden" name="table" value="{{ $table }}">
                                    <table id="datatable" class="table table-striped table-bordered dataTable no-footer" style="vertical-align: middle; margin-bottom: 0;">
                                        <thead>
                                        <tr>
                                            <th width="35px">col</th>
                                            <th>alias</th>
                                            <th>字段类型</th>
                                            <th>列表页</th>
                                            <th>添加页</th>
                                            <th>编辑页</th>
                                            <th>默认值</th>
                                            <th>来自哪张表</th>
                                            <th>option名</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($col as $k=>$v)
                                            <input type="hidden" name="field[{{ $v['col'] }}][col]" value="{{ $v['col'] }}">
                                            <tr>
                                                <td>{{ $v['col'] }}</td>
                                                <td><input type="text" name="field[{{ $v['col'] }}][alias]" value="{{ $v['alias'] }}"></td>
                                                <td>
                                                    <select name="field[{{ $v['col'] }}][type]" id="type" class="form-control">
                                                        @foreach ($type as $t)
                                                            <option value="{{ $t }}"
                                                                    @if ($t == $v['type'])
                                                                    selected="true"
                                                                    @endif
                                                            >{{ $t }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="js-switch" data-switchery="true"
                                                           @if($v['index'])
                                                           checked
                                                           @endif
                                                           name="field[{{ $v['col'] }}][index]" value="1" id="index">
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="js-switch" data-switchery="true"
                                                           @if($v['add'])
                                                           checked
                                                           @endif
                                                           name="field[{{ $v['col'] }}][add]" value="1" id="add">
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="js-switch" data-switchery="true"
                                                           @if($v['edit'])
                                                           checked
                                                           @endif
                                                           name="field[{{ $v['col'] }}][edit]" value="1" id="edit">
                                                </td>
                                                <td><input type="text" name="field[{{ $v['col'] }}][default]" value="{{ $v['default'] }}"></td>
                                                <td><input type="text" name="field[{{ $v['col'] }}][from_table]" value="{{ $v['from_table'] }}"></td>
                                                <td><input type="text" name="field[{{ $v['col'] }}][f_name]" value="{{ $v['f_name'] }}"></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@push('addcss')
<!-- Datatables -->
<link href="{{ asset('public/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">

@endpush

@push('addjs')
<script src="{{ asset('public/vendors/switchery/dist/switchery.min.js') }}"></script>
<script>
    $(function(){
        @foreach ($errors->all() as $e)
            new PNotify({
            title: 'Oh No!',
            text: '{{ $e }}',
            type: 'error'
        });
        @endforeach
    });


</script>
@endpush