@php
    $img = [];
    $date = [];
    $dateTime = [];
    $f_textarea = [];
    $radio = [];
    $checkbox = [];
@endphp
@@extends('layout.admin')

@@section('right_col')
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
                              action="{{ $l }}url('{{ strtolower('admin/'.$controller)}}'){{ $r }}" method="post">
                            @{{ csrf_field() }}
                            <span class="section">{{ $controller }}信息</span>

                            @foreach($col as $k=>$v)
                                @if(!$v['add'])
                                    @continue
                                @endif
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="{{ $v['col'] }}">{{ $v['alias'] }}</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        @php
                                            switch($v['type']){
                                                case 'select':
                                                        echo "<select name=\"{$v['col']}\" id=\"{$v['col']}\" class=\"form-control\">
                                                @@foreach (".'$'."{$v['from_table']}_{$v['f_name']}s as ".'$'."{$v['from_table']})
                                                    <option value=\"@{{ ".'$'."{$v['from_table']}->id }}\">@{{ ".'$'."{$v['from_table']}->{$v['f_name']} }}</option>
                                                @@endforeach
                                            </select>";
                                                        break;
                                                case 'checkbox':
                                                    $checkbox[] = $v['col'];
                                                    echo "<input type='hidden' name='{$v['col']}' value='0'/>\n";
                                                    echo "<input type=\"checkbox\" checked class=\"js-switch\" data-switchery=\"true\" name=\"{$v['col']}\" id=\"{$v['col']}\" value=\"1\">";
                                                    break;
                                                case 'number':
                                                     echo "<input id=\"{$v['col']}\" class=\"form-control col-md-7 col-xs-12\" name=\"{$v['col']}\" placeholder=\"请输入{$v['alias']}\" required=\"required\" value=\"{$v['default']}\" data-validate-minmax=\"0,\" type=\"number\">";
                                                     break;
                                                case 'textarea':
                                                    echo "<textarea id=\"{$v['col']}\" name=\"{$v['col']}\" class=\"form-control col-md-7 col-xs-12\">{$v['default']}</textarea>";
                                                    break;
                                                case 'image':
                                                    $image[] = $v['col'];
                                                    echo "<input type=\"file\" name=\"uploadImg\" class=\"uploadImg\" data-realname=\"{$v['col']}\">
                                            <input type=\"hidden\" name=\"{$v['col']}\">";
                                                    break;
                                                 default:
                                                        echo "<input id=\"{$v['col']}\" class=\"form-control col-md-7 col-xs-12\" name=\"{$v['col']}\" placeholder=\"请输入{$v['alias']}\" required=\"required\" value=\"{$v['default']}\" type=\"text\">";
                                                        break;
                                            }
                                        @endphp

                                    </div>
                                </div>
                            @endforeach

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
    @@endsection

@@push('addcss')
@if(isset($checkbox) && $checkbox)
    <link href="@{{ asset('public/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
@endif
@@endpush
@@push('addjs')
<script src="@{{ asset('public/vendors/validator/validator.js') }}"></script>
@if(isset($checkbox) && $checkbox)
    <script src="@{{ asset('public/vendors/switchery/dist/switchery.min.js') }}"></script>
@endif
<script>
    @@foreach ($errors->all() as $e)
        new PNotify({
        title: 'Oh No!',
        text: '@{{ $e }}',
        type: 'error'
    });
    @@endforeach

    @if($img)
    //  上传图片
    $(function () {
        $('.uploadImg').fileinput({
            showCaption: false,
            uploadAsync: true,
            uploadUrl: "/upload",
            initialPreview: [
                $('input[name=' + $(this).data('realname') + ']').val()
                    ? '<img style="max-height: 100%; max-width: 100%;display: block;" src="' + $('input[name=' + $(this).data('realname') + ']').val() + '" alt="">'
                    : ''
            ]
        }).on('filebatchselected', function (event, files) {
            $(this).fileinput('upload');
        }).on('fileuploaded', function (event, data, previewId, index) {
            var name = $(this).data('realname');
            $('input[name=' + name + ']').val(data.response.path);
        }).on('filesuccessremove fileclear filepreremove fileremoved filepredelete filedeleted ', function (event, id) {
            var name = $(this).data('realname');
            var path = $('input[name=' + name + ']').val();
            var img = $('input[name=' + $(this).data('realname') + ']');

            $.ajax({
                url: '/upload',
                data: {
                    path: path
                },
                method: "DELETE",
                success: function () {
                    img.val("");
                }
            });
        })
    });
    @endif

</script>
@@endpush