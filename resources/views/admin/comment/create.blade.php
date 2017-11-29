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
                              action="{{ url('admin/comment') }}" method="post">
                            {{ csrf_field() }}
                            <span class="section">Comment信息</span>

                                                                                                                                                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="content">评论内容</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="content" class="form-control col-md-7 col-xs-12" name="content" placeholder="请输入评论内容" required="required" value="" type="text">
                                    </div>
                                </div>
                                                                                            <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="zan">赞</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input id="zan" class="form-control col-md-7 col-xs-12" name="zan" placeholder="请输入赞" required="required" value="" type="text">
                                    </div>
                                </div>
                                                                                            <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="articel">文章id</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="articel" id="articel" class="form-control">
                                                @foreach($articel_ids as $articel)
                                                    <option value="{{ $articel->id }}">{{ $articel->id }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                                                                                            <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="show">是否显示</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type='hidden' name='show' value='0'/>
<input type="checkbox" checked class="js-switch" data-switchery="true" name="show" id="show" value="1">
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
    <link href="{{ asset('public/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
@endpush
@push('addjs')
<script src="{{ asset('public/vendors/validator/validator.js') }}"></script>
    <script src="{{ asset('public/vendors/switchery/dist/switchery.min.js') }}"></script>
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