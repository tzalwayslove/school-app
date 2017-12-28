@extends('layout.admin')

@section('right_col')
    <div class="right_col">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>微信文字</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div id="table" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                <div class="col-sm-12">
                                    <table id="datatable" class="table table-striped table-bordered dataTable no-footer"
                                           style="vertical-align: middle; margin-bottom: 0;">
                                        <thead>
                                        <tr>
                                            <th width="35px">类型</th>
                                            <th width="35px">key</th>
                                            <th width="35px">值</th>
                                            <th width="75px">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($list as $v)
                                            <tr class="list-tr">
                                                <td>{{$v->type}}</td>
                                                <td>{{$v->key}}</td>
                                                <td class="content-td">{{$v->content}}</td>
                                                <td>
                                                    <button class="btn btn-info btn-xs edit">编辑</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
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
<link href="/public/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="/public/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="/public/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css"
      rel="stylesheet">
<link href="/public/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"
      rel="stylesheet">
<link href="/public/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

@endpush

@push('addjs')
<script src="/public/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/public/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="/public/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="/public/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="/public/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="/public/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="/public/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="/public/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="/public/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="/public/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="/public/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="/public/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script>
    $(function () {
        $('#datatable').DataTable();

        @foreach ($errors -> all() as $e)
        new PNotify({
            title: 'Oh No!',
            text: '{{ $e }}',
            type: 'error'
        });
        @endforeach
        $('.edit').on('click', function(){
            $tr = $(this).parents('.list-tr');
            contentText = $tr.find('.content-td').html();
            layui.use('layer', function(){
                layer = layui.layer;
                layer.open({
                    content: '<textarea class="edit_content" style="width: 550px; height: 200px">' +
                    contentText +
                    '</textarea>',
                    area:'600px',
                    yes:function(index){
                        console.log(index);
                        console.log(1111111);
                    }
                });
            })
        });

    });


</script>
@endpush