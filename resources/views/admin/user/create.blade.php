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
                              action="{{ url('admin/user') }}" method="post">
                            {{ csrf_field() }}
                            <span class="section">User信息</span>

                                                                                                                                ;
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="account">账户</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="account" class="form-control col-md-7 col-xs-12" name="account" placeholder="请输入账户" required="required" value="" type="text">
                                    </div>
                                </div>
                                                                                                                                                                                                                                                                                                                                            ;
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sex">性别</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="sex" class="form-control col-md-7 col-xs-12" name="sex" placeholder="请输入性别" required="required" value="" type="text">
                                    </div>
                                </div>
                                                                                                                                                                                                    ;
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="updated_at"></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="updated_at" class="form-control col-md-7 col-xs-12" name="updated_at" placeholder="请输入" required="required" value="" type="text">
                                    </div>
                                </div>
                                                            ;
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="deleted_at"></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="deleted_at" class="form-control col-md-7 col-xs-12" name="deleted_at" placeholder="请输入" required="required" value="" type="text">
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