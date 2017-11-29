@extends('layout.admin')

@section('right_col')
    <div class="right_col">
        <div class="page-title">
            <div class="title_left">
                <h2>添加新分类</h2>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <form class="form-horizontal form-label-left" novalidate data-parsley-validate
                              action="{{ url('admin/articel') }}" method="post">
                            {{ csrf_field() }}
                            <span class="section">Articel信息</span>

                            ;
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="content">内容</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea id="content" name="content"
                                              class="form-control col-md-7 col-xs-12"></textarea>
                                </div>
                            </div>
                            ;
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user">用户名</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="user" class="form-control col-md-7 col-xs-12" name="user"
                                           placeholder="请输入用户名" required="required" value="" type="text">
                                </div>
                            </div>
                            ;
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cate">分类</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="cate" class="form-control col-md-7 col-xs-12" name="cate"
                                           placeholder="请输入分类" required="required" value="" type="text">
                                </div>
                            </div>
                            ;
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="show">是否显示</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="show" class="form-control col-md-7 col-xs-12" name="show"
                                           placeholder="请输入是否显示" required="required" value="" type="text">
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button type="reset" class="btn btn-primary">取消</button>
                                    <button id="send" type="submit" class="btn btn-success">确定</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addcss')
@endpush
@push('addjs')
<script src="{{ asset('public/vendors/validator/validator.js') }}"></script>
<script>
    @foreach($errors->all() as $e)
        new PNotify({
        title: 'Oh No!',
        text: '{{ $e }}',
        type: 'error'
    });
    @endforeach


</script>
@endpush