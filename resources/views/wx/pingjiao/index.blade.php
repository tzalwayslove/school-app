<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="id" content="{{ $userId }}">
    <link rel="stylesheet" href="{{ asset('public/vendors/weui/weui.css') }}">
    <script src="{{ asset('/public/vendors/jquery/dist/jquery.js') }}"></script>
    <script src="{{ asset('/public/js/jquery-laravel-ajax.js') }}"></script>
    <title>一键评教</title>
</head>
<body>
<div id="loadingToast" v-show="jiazai">
    <div class="weui-mask_transparent"></div>
    <div class="weui-toast">
        <i class="weui-loading weui-icon_toast"></i>
        <p class="weui-toast__content">数据加载中</p>
    </div>
</div>
<script>
    $(function(){
        $('#loadingToast').show();
        $.postData('/wx/pingjiao',{
            user:$('meta[name="id"]').attr('content')
        }, function (res) {
            $('#loadingToast').hide();
            if(res.result.code == 1){
                alert('评教成功');
                window.location.href = '/?user=12#/wode'
            }else{
                alert(res.result.message || '评教失败!');
                if(res.result.message == '用户名或密码为空， 请绑定正确的账户'){
                    window.location.href = '/wx/binding/?user=12'
                }else{
                    window.location.href = '/?user=12#/wode'
                }
            }
        });
    });
</script>
</body>
</html>