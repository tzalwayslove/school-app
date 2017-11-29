@extends('layout.admin')

@section('right_col')
    <div class="right_col">
        <div class="page-title">
            <div class="title_left">
                <h2>编辑Articel</h2>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <form class="form-horizontal form-label-left" novalidate data-parsley-validate
                              action="{{  url("admin/articel/$data->id") }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <span class="section">Articel信息</span>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                       for="content">内容</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea id="content" name="content"
                                              class="form-control col-md-7 col-xs-12">{{ $data->content }}</textarea>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                       for="user">用户名</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="user" id="user" class="form-control">
                                        @foreach($user_accounts as $user)
                                            <option
                                                    @if($user->id == $data->user)
                                                    selected="true"
                                                    @endif
                                                    value="{{ $user->id }}">{{ $user->account }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                       for="cate">分类</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="cate" id="cate" class="form-control">
                                        @foreach($cate_names as $cate)
                                            <option
                                                    @if($cate->id == $data->cate)
                                                    selected="true"
                                                    @endif
                                                    value="{{ $cate->id }}">{{ $cate->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                       for="show">是否显示</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="checkbox"
                                           @if($data->show)
                                           checked="true"
                                           @endif
                                           class="js-switch" data-switchery="true" name="show" id="show"
                                           value="{{ $data->show }}">
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

                <div class="x_panel">
                    <div class="x_content">
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                            <tr class="headings">
                                <th class="column-title">评论id</th>
                                <th class="column-title">评论时间</th>
                                <th class="column-title">内容</th>
                                <th class="column-title">赞</th>
                                <th class="column-title">是否显示</th>
                                <th class="column-title">评论人</th>
                                <th class="column-title no-link last"><span class="nobr">操作</span>
                                </th>
                                <th class="bulk-actions" colspan="7">
                                    <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span
                                                class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                </th>
                            </tr>
                            </thead>

                            <tbody>

                            @if($data->getComment->isEmpty())
                                <tr>
                                    <td>暂无评论</td>
                                </tr>
                            @else
                            <tr class="even pointer">
                                <td class=" ">{{$comment->id}}</td>
                                <td class=" ">{{ $comment->create_at }}</td>
                                <td class=" ">{{ $comment->content }}</td>
                                <td class=" ">{{ $comment->zan or 0 }}</td>
                                <td class=" ">
                                    <input type="checkbox"
                                           @if($data->show) checked @endif
                                           class="js-switch comment-show" data-switchery="true"
                                           value="{{ $comment->show }}"
                                           data-id="{{ $comment->id }}"
                                    >
                                </td>
                                <td class="a-right a-right ">$7.45</td>
                                <td class=" last"><a href="#">View</a>
                                </td>
                            </tr>
                            @endif();
                            </tbody>
                        </table>
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
<script src="{{ asset('public/vendors/vue/vue.js') }}"></script>
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