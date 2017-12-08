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
    <link rel="stylesheet" href="{{ asset('public/css/we/main.css') }}">
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

        #add_pinglun input {
            width: 80%;
        }

        #add_pinglun button {
            width: 15%;
        }

        #add_pinglun_show {
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

        #remen {
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
    <div class="page tabfabu js_show">
        <div class="page__bd" style="height: 100%;">
            <div class="weui-tab">
                <router-view></router-view>
                <div class="weui-tabbar">
                    <div class="my-bottom">

                    </div>
                    {{--<router-link to="/tiezi"
                                 v-bind:class="['weui-tabbar__item', nav_active == 'tiezi' ? 'weui-bar__item_on' : '']">
                        <div style="height: 10px;"></div>
                    <span style="display: inline-block;position: relative;">
                        <img src="{{asset('public/images/icon-index.png')}}" alt="" class="weui-tabbar__icon">
                    </span>
                        <div style="height: 10px;"></div>
                    </router-link>
                    <router-link to="/fabu"
                                 v-bind:class="['weui-tabbar__item', nav_active == 'fabu' ? 'weui-bar__item_on' : '']">
                        <div style="height: 10px;"></div>
                    <span style="display: inline-block;position: relative;">
                        <img src="{{asset('public/images/icon-fabu.png')}}" alt="" class="weui-tabbar__icon">
                    </span>
                        --}}{{--<p class="weui-tabbar__label">发帖</p>--}}{{--
                        <div style="height: 10px;"></div>
                    </router-link>
                    <router-link to="/wode"
                                 v-bind:class="['weui-tabbar__item', nav_active == 'wode' ? 'weui-bar__item_on' : '']">
                        <div style="height: 10px;"></div>
                        <span style="display: inline-block;position: relative;">
                        <img src="{{asset('public/images/icon-wode.png')}}" alt="" class="weui-tabbar__icon">
                        </span>
                        <div style="height: 10px;"></div>
                    </router-link>--}}
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
        axios.defaults.baseURL = 'http://school.sz25.net';
        axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');
    });
</script>
<script src="{{ asset('public/vue/index.js') }}"></script>
<script src="{{ asset('public/vue/fabu.js') }}"></script>
<script src="{{ asset('public/vue/wode.js') }}"></script>
<script src="{{ asset('public/vue/pinglun.js') }}"></script>
<script>
    const routes = [
        {path: '/tiezi', component: tiezi, name: 'tiezi'},
        {path: '/fabu', component: fabu, name: 'fabu'},
        {path: '/wode', component: wode, name: 'wode'},
        {path: '/pinglun/:id', component: pinglun, name: 'pinglun', props: {articel: 0}}
    ];

    const router = new VueRouter({
        routes: routes,
        default: 'tiezi'
    });

    data = {
        nav_active: 'tiezi',
        tiezi: [],
        user: {}
    };

    router.beforeEach((to, from, next) => {
        switch (to.name) {
            case "pinglun":
                data.nav_active = 'tiezi';
                break;
            default:
                console.log(to.name);
                data.nav_active = to.name;
        }
        next();
    });

    vue = new Vue({
        router: router,
        data: data,
        load: true,
        methods: {},
        mounted: function () {
            router.push({
                path: '/tiezi'
            })
        }
    }).$mount('#app');
</script>
<script>
    var a =document.getElementsByTagName('html')[0].width;
    b.style.fontSize=a/10 + 'px';

</script>
</body>
</html>