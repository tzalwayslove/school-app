<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('public/vendors/weui/weui.css') }}">
    <link rel="stylesheet" href="{{ asset('public/vendors/weui/example.css') }}">
    <script src="{{ asset('public/vendors/weui/zepto.min.js') }}"></script>
    <style>
        .weui-cells {
            margin-top: 0
        }
        #add_pinglun {
            position: fixed;
            padding: 20px;
            bottom: 70px;
            width: 100%;
            box-sizing: border-box;
            right: 0;
            z-index: 100;
            background: #eee;
        }
        #add_pinglun input{
            width:80%;
        }
        #add_pinglun button{
            width: 15%;
        }
        #add_pinglun_show{
            position: fixed;
            right: 20px;
            bottom: 70px;
            width: 75px;
            height: 75px;
            border-radius: 50%;
            background: rgba(51, 103, 214, 0.8);
            z-index: 100;
            line-height: 75px;
            text-align: center;
            font-size: 66px;
            color: #FFF;
        }
        #remen{
            position: fixed;
            right: 20px;
            bottom: 70px;
            height: 75px;
            width: 75px;
            text-align: center;
            line-height: 75px;
            background: #ccc;
            border-radius: 50%;
        }
    </style>

    <title></title>
</head>
<body>

<div id="app" class="container">

    <Chengjiall user="{{$user}}"/>
</div>
<script src="{{ asset('public/vendors/vue/vue.js') }}"></script>
<script src="{{ asset('public/vendors/vue/vue-router.js') }}"></script>
<script src="{{ asset('public/vendors/vue/axios.min.js') }}"></script>

<script src="{{ asset('public/vendors/weui/weui.min.js') }}"></script>
<script type="text/javascript">
    $(function () {
        axios.defaults.baseURL = 'http://www.hucinfo.com';
        axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
    });
</script>
<script src="{{ asset('public/vue/chengji_all.js') }}"></script>
<script>
    data = {

    };

    vue = new Vue({
        data: data,
        load: true,
        methods: {

        },
        mounted:function(){

        }
    }).$mount('#app');
</script>
</body>
</html>