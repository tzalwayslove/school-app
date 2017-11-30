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
    </style>

    <title></title>
</head>
<body>
<div id="app" class="container">
    <div class="page tabfabu js_show">

        <div class="page__bd" style="height: 100%;">
            <div class="weui-tab">


                <div class="weui-tab__panel">
                    <router-view></router-view>
                </div>
                <div class="weui-tabbar">
                    <router-link to="/tiezi"
                                 v-bind:class="['weui-tabbar__item', nav_active == 'tiezi' ? 'weui-fabu__item_on' : '']">
                    <span style="display: inline-block;position: relative;">
                        <img src="{{asset('public/images/icon_tabbar.png')}}" alt="" class="weui-tabbar__icon">
                    </span>
                        <p class="weui-tabbar__label">帖子</p>
                    </router-link>
                    <router-link to="/fabu"
                                 v-bind:class="['weui-tabbar__item', nav_active == 'fabu' ? 'weui-fabu__item_on' : '']">
                        <img src="{{asset('public/images/icon_tabbar.png')}}" alt="" class="weui-tabbar__icon">
                        <p class="weui-tabbar__label">发帖</p>
                    </router-link>
                    <router-link to="/wode"
                                 v-bind:class="['weui-tabbar__item', nav_active == 'wode' ? 'weui-fabu__item_on' : '']">
                    <span style="display: inline-block;position: relative;">
                        <img src="{{asset('public/images/icon_tabbar.png')}}" alt="" class="weui-tabbar__icon">
                    </span>
                        <p class="weui-tabbar__label">发现</p>
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
    /*$(function () {
     $('.weui-tabfabu__item').on('click', function () {
     $(this).addClass('weui-fabu__item_on').siblings('.weui-fabu__item_on').removeClass('weui-fabu__item_on');
     });
     });*/
    $(function () {
        axios.defaults.baseURL = 'http://school.sz25.net';
        axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
    });
</script>
<script>

    tiezi = Vue.component('tiezi', function (success, error) {
        axios.get("/public/tpl/index.html").then(function (res) {
            success({
                template: res.data
            });
        });
    });

    tiezi = Vue.component('fabu', function (success, error) {
        axios.get("/public/tpl/index.html").then(function (res) {
            success({
                template: res.data
            });
        });
    });

    fabu = Vue.component('wode', function (resolve, reject) {
        axios.get("/public/tpl/pinglun.html").then(function (res) {
            resolve({
                template: res.data
            });
        });
    });
    const routes = [
        {path: '/tiezi', component: tiezi, name: 'tiezi'},
        {path: '/fabu', component: fabu, name: 'fabu'},
        {path: '/wode', component: fabu, name: 'wode'},
    ];

    const router = new VueRouter({
        routes: routes
    });

    data = {
        nav_active: 'tiezi'
    };

    router.beforeEach((to, from, next) => {
        data.nav_active = to.name;
        next();
    });


    vue = new Vue({
        router: router,

        data: data,

        methods: {},

    }).$mount('#app');
</script>
</body>
</html>