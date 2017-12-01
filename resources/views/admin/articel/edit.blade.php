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

                <div class="x_panel" id="comments"
                     data-url="{{ url('api/admin/comment', ['id'=>$data->id]) }}"
                     data-show_url="{{ url('api/admin/comment/show') }}"
                >
                    <div class="x_content">
                        <table class="table table-hover">
                            <thead>
                            <tr class="headings">
                                <th class="column-title">评论id</th>
                                <th class="column-title">评论时间</th>
                                <th class="column-title">内容</th>
                                <th class="column-title">赞</th>
                                <th class="column-title">是否显示</th>
                                <th class="column-title">评论人</th>
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr class="even pointer" v-for="item in comments">
                                <td class=" ">@{{item.id}}</td>
                                <td class=" ">@{{item.created_at}}</td>
                                <td class=" ">@{{item.content}}</td>
                                <td class=" ">@{{item.zan ? item.zan : 0}}</td>
                                <td class=" ">
                                    <input type="checkbox"
                                           :checked="item.show == 1"
                                           @change="test(item, $event)"
                                           class="js-switch" data-switchery="true"
                                    >
                                </td>
                                {{--<td class="a-right a-right ">@{{item.get_user.account}}</td>--}}
                                <td class="a-right a-right ">@{{item.get_user.account || '匿名'}}</td>

                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <button class="btn btn-dark" v-if="preUrl" @click="pre">上一页</button>
                    <button class="btn btn-danger" v-if="nextUrl" @click="next">下一页</button>

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
    var v = new Vue({
            el: '#comments',
            data: {
                comments: [],
                nextUrl: null,
                preUrl:null
            },
            methods: {
               test: function (item, event) {
                    id = item.id;

                    $.post($('#comments').data('show_url'), {
                        id: id,
                        show: $(event.target).is(':checked') ? 1: 0
                    }, function(res){
                        if(res.result.code != 1){
                            alert('设置失败');
                        }
                    });
                },
                pre:function(){
                    $this = this;
                    $.get(this.preUrl, function (res) {
                        $this.comments = res.data;
                        $this.nextUrl = res.next_page_url;
                        $this.preUrl = res.prev_page_url;
                    });
                },
                next:function(){
                    $this = this;
                    $.get(this.nextUrl, function (res) {
                        $this.comments = res.data;
                        $this.nextUrl = res.next_page_url;
                        $this.preUrl = res.prev_page_url;
                    });
                }
            },
            mounted: function () {
                $this = this;
                $.get($('#comments').data('url'), function (res) {
                    $this.comments = res.data;
                    $this.nextUrl = res.next_page_url;
                    $this.preUrl = res.prev_page_url;
                });
            }
        });
    $(function () {

    })
</script>
@endpush