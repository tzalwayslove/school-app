<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>遇见 @ 一卡通流水</title>
    <link rel="stylesheet" href="/public/vendors/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="/public/vendors/weui/weui.css">
    <style>
        .item{
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #eee;
            border-left-width: 5px;
            border-radius: 3px;
            border-left-color: #aa6708;
        }
    </style>
</head>

<body>
<div id="app">
    <Liushui user="{{$request->input('user')}}"></Liushui>
</div>
<script src="/public/vendors/jquery/dist/jquery.js"></script>
<script src="/public/vendors/bootstrap/dist/js/bootstrap.js"></script>
<script src="{{ asset('public/vendors/vue/vue.js') }}"></script>
<script src="{{ asset('public/vendors/vue/vue-router.js') }}"></script>
<script src="{{ asset('public/vendors/vue/axios.min.js') }}"></script>

<script type="text/javascript">
    $(function () {
        axios.defaults.baseURL = 'http://school.sz25.net';
        axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
    });
</script>
<script src="{{ asset('public/vue/liushui.js') }}"></script>
<script>
    data = {
        user: '{{$request->user }}'
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
