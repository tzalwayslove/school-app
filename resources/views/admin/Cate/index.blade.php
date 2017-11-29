@extends('layout.admin')

@section('right_col')
    <div class="right_col">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Cate列表</h3>
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
                                            <th width="35px">id</th>
                                            <th width="35px">标题名</th>
                                            <th width="35px">是否显示</th>
                                            <th width="35px">创建时间</th>
                                            <th width="75px">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($list as $v)
                                            <tr>
                                                <td>{{ $v->id }}</td>
                                                <td>{{ $v->name }}</td>
                                                @php$arrstr = ['否', '是'];@endphp
                                                <td>{{ $arrstr[$v->show] }}</td>
                                                <td>{{ $v->updated_at }}</td>

                                                <td>
                                                    <a href="{{ url('admin/cate/'.$v->id.'/edit')  }}"
                                                       class="btn btn-info btn-xs">编辑</a>
                                                    <a href="{{ url('admin/cate', ['id'=>$v->id])  }}"
                                                       class="btn btn-danger btn-xs del">删除</a>
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
<link href="http://www.school.dy/public/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="http://www.school.dy/public/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css"
      rel="stylesheet">
<link href="http://www.school.dy/public/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css"
      rel="stylesheet">
<link href="http://www.school.dy/public/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"
      rel="stylesheet">
<link href="http://www.school.dy/public/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css"
      rel="stylesheet">

@endpush

@push('addjs')
<script src="http://www.school.dy/public/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="http://www.school.dy/public/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="http://www.school.dy/public/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="http://www.school.dy/public/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="http://www.school.dy/public/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="http://www.school.dy/public/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="http://www.school.dy/public/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="http://www.school.dy/public/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="http://www.school.dy/public/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="http://www.school.dy/public/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="http://www.school.dy/public/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="http://www.school.dy/public/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<script>
    $(function () {
        $('#datatable').DataTable();
        $('body').on('click', '.del', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var _this = this;
            $.ajax({
                url: url,
                type: 'DELETE',
                success: function (res) {
                    var status = res.status | 0;
                    if (status) {
                        $(_this).parents('tr').fadeOut(300, function () {
                            $(this).remove();
                        });
                    }
                },
                error: function (res) {
                    console.log(res);
                }
            });
        });
        @foreach ($errors -> all() as $e)
        new PNotify({
            title: 'Oh No!',
            text: '{{ $e }}',
            type: 'error'
        });
        @endforeach
    });


</script>
@endpush