<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="id" content="{{ $userId }}">
    <script src="{{ asset('public/vendors/weui/zepto.min.js') }}"></script>
    <script src="{{ asset('/public/js/jquery-laravel-ajax.js') }}"></script>
    <title>一键评教</title>
</head>
<body>
<script>
    $(function(){
        $.postData('/wx/pingjiao',{
            user:$('meta[name="id"]').attr('content')
        }, function (res) {
            if(res.result.code == 1){
                alert('评教成功');
                window.location.href = '/?user=12#/wode'
            }else{
                alert(res.result.message || '评教失败!');
            }
        });
    });
</script>
</body>
</html>