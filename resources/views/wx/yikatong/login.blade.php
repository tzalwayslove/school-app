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
<form action="/yikatonglogin">
    <img src="{{ url('/wx/yikatongCode') }}" alt="">
    <input type="text" name="code">
    <input type="submit">
</form>
</body>
</html>