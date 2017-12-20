@extends('layout.admin')

@section('right_col')
    <div class="right_col">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Articel列表</h3>
                </div>
                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                              <button class="btn btn-default" type="button">Go!</button>
                            </span>
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
                                    <table id="datatable" class="table table-striped table-bordered dataTable no-footer"
                                           style="vertical-align: middle; margin-bottom: 0;">
                                        <thead>
                                        <tr>
                                            <th width="35px">id</th>
                                            <th>内容</th>
                                            <th width="35px">赞</th>
                                            <th width="35px">用户名</th>
                                            <th width="35px">分类</th>
                                            <th width="35px">是否显示</th>
                                            <th width="35px">创建时间</th>
                                            <th width="75px">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($list as $v)
                                            <tr>
                                                <td>{{ $v->id }}</td>
                                                <td>{{ $v->content }}</td>
                                                <td>{{ $v->zan or 0 }}</td>
                                                <td>{{ isset($v->user_account)? $v->user_account->account : '匿名' }}</td>
                                                <td>{{ isset($v->cate_name)? $v->cate_name->name : '无' }}</td>
                                                @php$arr = ['否', '是'];@endphp
                                                <td>{{ $arr[$v->show] }}</td>

                                                <td>{{ $v->updated_at }}</td>

                                                <td>
                                                    <a href="{{ url('admin/articel/'.$v->id.'/edit')  }}"
                                                       class="btn btn-info btn-xs">编辑</a>
                                                    <a href="{{ url('admin/articel', ['id'=>$v->id])  }}"
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


@endpush

@push('addjs')

<script>
    $(function () {
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