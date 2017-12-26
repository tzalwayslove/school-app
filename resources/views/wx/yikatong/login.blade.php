<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>一卡通登录</title>
</head>
<body>

<form method="post" id="form">
    {{ csrf_field() }}
    <img src="{{ url('/wx/yikatongCode') }}" alt="">
    <input type="text" name="user_name" placeholder="用户名" id="user_name" disabled="disabled" value="{{ $user->account or ""}}">
    <input type="text" name="password" placeholder="密码" id="password" disabled="disabled" value="{{ $user->yikatong_password or ""}}">
    <input type="number" name="code" placeholder="验证码" maxlength="2" id="code">
    <button id="login" type="button">登录</button>
</form>
<script src="{{ asset('/public/vendors/jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('/public/js/jquery-laravel-ajax.js') }}"></script>

<script>
    $(function(){
        $('#login').on('click', function(){
            data = {
                user_name : $('#user_name').val(),
                password : $('#password').val(),
                code:$('#code').val()
            };
            $.postData($('#form').attr('action'), data, function(res){
                if(res.result.code == 1){
                    alert('登录成功');
                    if(typeof res.target != 'undefined'){
                        window.location.href=res.target
                    }else{
                        window.history.go(-1);
                    }
                }else{
                    alert(res.result.message || '登录失败, 请重新输入用户名和密码');
                    $('input[name=user_name]').removeAttr('disabled');
                    $('input[name=password]').removeAttr('disabled');
                }
            })
        });
    });
</script>
</body>
</html>