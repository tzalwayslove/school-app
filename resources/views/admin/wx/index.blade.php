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
        .weui-cells{
            margin-top:0
        }
    </style>

    <title></title>
</head>
<body>
<div id="app" class="container">
    <div class="page tabbar js_show">

        <div class="page__bd" style="height: 100%;">
            <div class="weui-tab">
                <div class="weui-tab__panel">
                    <router-view></router-view>
                </div>
                <div class="weui-tabbar">
                    <router-link to="/foo" v-bind:class="[weui-tabbar__item, nav_active == foo ? weui-bar__item_on : '']">
                    <span style="display: inline-block;position: relative;">
                        <img src="{{asset('public/images/icon_tabbar.png')}}" alt="" class="weui-tabbar__icon">
                        {{--<span class="weui-badge" style="position: absolute;top: -2px;right: -13px;"></span>--}}
                    </span>
                        <p class="weui-tabbar__label">帖子</p>
                    </router-link>
                    <router-link to="/foo" v-bind:class="[weui-tabbar__item, nav_active == foo ? weui-bar__item_on : '']">
                        <img src="{{asset('public/images/icon_tabbar.png')}}" alt="" class="weui-tabbar__icon">
                        <p class="weui-tabbar__label">发布</p>
                    </router-link>
                    <router-link to="/bar" v-bind:class="[weui-tabbar__item, nav_active == bar ? weui-bar__item_on : '']">
                    <span style="display: inline-block;position: relative;">
                        <img src="{{asset('public/images/icon_tabbar.png')}}" alt="" class="weui-tabbar__icon">
                        {{--<span class="weui-badge weui-badge_dot" style="position: absolute;top: 0;right: -6px;"></span>--}}
                    </span>
                        <p class="weui-tabbar__label">我的</p>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('public/vendors/vue/vue.js') }}"></script>
<script src="{{ asset('public/vendors/vue/vue-router.js') }}"></script>
<script src="{{ asset('public/vendors/vue/axios.min.js') }}"></script>

<script src="{{ asset('public/vendors/weui/weui.min.js') }}"></script>
<script type="text/javascript">
    $(function () {
        $('.weui-tabbar__item').on('click', function () {
            $(this).addClass('weui-bar__item_on').siblings('.weui-bar__item_on').removeClass('weui-bar__item_on');
        });
    });
    $(function(){
        axios.defaults.baseURL = 'http://school.sz25.net';
        axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
    });
</script>
<script>

    foo = Vue.component('foo', function(success, error){
        axios.get("/public/tpl/index.html").then(function(res){
            success({
                template:res.data
            });
        });
    });

    bar = Vue.component('bar', function(resolve, reject){
        axios.get("/public/tpl/pinglun.html").then(function (res) {
            resolve({
                template: res.data
            });
        });
    });
    const routes = [
        {path: '/foo', component: foo},
        {path: '/bar', component: bar}
    ];

    const router = new VueRouter({
        routes: routes
    });

    router.beforeEach((to, from, next) => {
        console.log(to);
        console.log(from);
        console.log(next);
    });

    vue = new Vue({
        router: router,

        data: {
            nav_active: 'foo'
        },

        methods: {},

    }).$mount('#app');
</script>
</body>
</html>