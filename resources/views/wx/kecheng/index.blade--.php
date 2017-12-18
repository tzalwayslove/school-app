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
    <title></title>
</head>
<body>

<div style="margin-top: 54px;" id="app">
    <Kecheng user="{{$request->input('user')}}" all="{{$request->input('all')}}"/>
</div>

<script src="{{ asset('public/vendors/vue/vue.js') }}"></script>
<script src="{{ asset('public/vendors/vue/vue-router.js') }}"></script>
<script src="{{ asset('public/vendors/vue/axios.min.js') }}"></script>

<script src="{{ asset('public/vendors/weui/weui.min.js') }}"></script>
<script type="text/javascript">
    $(function () {
        axios.defaults.baseURL = 'http://school.sz25.net';
        axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
    });
</script>
<script src="{{ asset('public/vue/kecheng.js') }}"></script>
<script>

    data = {
        nav_active: 'tiezi',
        tiezi:[],
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

