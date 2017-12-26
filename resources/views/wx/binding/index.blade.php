<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="id" content="{{ $userId }}">
    <title>绑定教务处账号@遇见商大Pro</title>
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
<div class="input-in">
    学号:<input type="text" class="bind-input-style" placeholder="请输入你的学号" id="account"/>
</div>
<div class="input-in">
    密码:<input type="text" class="bind-input-style2" placeholder="请输入教务处密码" id="password"/>
</div>
<div style="margin:30px 15% 10px;">
    <input type="button" value="确认绑定" style="width: 100%; text-align: center;border: 1px solid #FFFFFF;border-radius: 30px;margin: 0;background: #FFFFFF;color: #3CC3B6;font-size: 18px;
	padding:12px;" id="binding" />
    <p style="font-size: 10px;color: #FFFFFF;text-align: center;">您尚未绑定，请先进行绑定开启你的教务旅程</p>
</div>
<div class="fix-bott">
    <p class="fix-bott-p">希望我们不只是遇见</p>
    <p class="fix-bott-p">copyright©   2017 遇见商大</p>
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
                alert('请输入正确账户和密码!');
            }
            data = {
                account:account,
                password:password,
                user:$('meta[name="id"]').attr('content')
            };
            $.postData('/wx/binding', data, function(res){
                if(res.result.code == 1){
                    //跳转
                    window.location.href='/wx/bind-success/?user='+data.user;
                }else{
                    alert('绑定失败，请稍后再试!'||res.result.message);
                }
            });
        });
    });
</script>
</body>

</html>