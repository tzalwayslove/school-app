<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="id" content="{{ $userId }}">
    <title>绑定账号@遇见商大Pro</title>
    <link href="/public/wx/css/mui.css" rel="stylesheet"/>
    <link href="/public/wx/css/index.css" rel="stylesheet"/>
    <style>
        body{
            background: #3cc4b6;
        }
    </style>
</head>
<body>
<p class="bind-logo">
    <img src="/public/wx/img/yj-m-logo.png" class="bind-logo-img" />
</p>
<p class="bind-title">
   遇见商大Pro
</p>
<div class="input-in">
    学号<input type="text" class="bind-input-style" placeholder="点击此处输入学号" id="account"/>
</div>
<div class="input-in">
    密码<input type="text" class="bind-input-style" placeholder="点击此处输入教务处密码" id="password"/>
</div>
<div style="margin:30px 15% 10px;">
    <button class="m-btn-bal" id="binding" >绑&nbsp; 定</button>
    <p style="font-size: 13px;color: #FFFFFF;text-align: center;margin-top:13px;" id="info">您尚未绑定，请先进行绑定即可开启你的教务旅程</p>
</div>
<div class="fix-bott">
    <p class="fix-bott-p">
    <img src="/public/wx/img/bind-j-l.png" class="bind-j">
    希望我们不只是遇见
    <img src="/public/wx/img/bind-j-r.png" class="bind-j">
</p>
    <p class="fix-bott-p">Copyright © 2018 遇见商大Pro</p>
</div>
<script src="{{ asset('/public/vendors/jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('/public/js/jquery-laravel-ajax.js') }}"></script>
<script>
    $(function(){
        $('input').on('focus', function(){
            $('.fix-bott').hide()
        });
        $('input').on('blur', function(){
            $('.fix-bott').show()
        });
        $('#binding').on('click', function(){
            account = $('#account').val();
            password = $('#password').val();
            if(account == '' || password == ''){
                alert('用户名或密码不能为空');
            }
            data = {
                account:account,
                password:password,
                user:$('meta[name="id"]').attr('content')
            };
            $.postData('/wx/binding', data, function(res){
                console.log(res);
                if(res.result.code == 1){
                    window.location.href='/wx/bind-success/?user='+data.user;
                }else if(res.result.code == -2){
                    alert('绑定失败， 请检查用户名密码');
                    $('#info').html('您输入的学号或密码有误，如忘记密码，请在公众号内回复忘记密码，重置教务处密码至身份证后六位').style({color:'red'});
                }else {
                    alert('绑定失败，请重新绑定'||res.result.message);
                }
            });
        });
    });
</script>
</body>

</html>