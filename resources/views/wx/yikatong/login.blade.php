<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>一卡通登录</title>
</head>
<body>

<form action="{{ url('/wx/yikatonglogin') }}" method="post">
    {{ csrf_field() }}
    <img src="{{ url('/wx/yikatongCode') }}" alt="">
    <input type="text" name="user_name" placeholder="用户名">
    <input type="text" name="password" placeholder="密码">
    <input type="number" name="code" placeholder="验证码" maxlength="2">
    <input type="submit">
</form>

</body>
</html>