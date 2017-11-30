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
                    <router-view></router-view>
                <div class="weui-tabbar">
                    <router-link to="/tiezi"
                                 v-bind:class="['weui-tabbar__item', nav_active == 'tiezi' ? 'weui-bar__item_on' : '']">
                    <span style="display: inline-block;position: relative;">
                        <img src="{{asset('public/images/icon_tabbar.png')}}" alt="" class="weui-tabbar__icon">
                    </span>
                        <p class="weui-tabbar__label">帖子</p>
                    </router-link>
                    <router-link to="/fabu"
                                 v-bind:class="['weui-tabbar__item', nav_active == 'fabu' ? 'weui-bar__item_on' : '']">
                        <img src="{{asset('public/images/icon_tabbar.png')}}" alt="" class="weui-tabbar__icon">
                        <p class="weui-tabbar__label">发帖</p>
                    </router-link>
                    <router-link to="/wode"
                                 v-bind:class="['weui-tabbar__item', nav_active == 'wode' ? 'weui-bar__item_on' : '']">
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
        {path: '/pinglun/:id', component: pinglun, name:'pinglun', props:{articel: 0}}
    ];

    const router = new VueRouter({
        routes: routes,
        default: 'tiezi'
    });

    data = {
        nav_active: 'tiezi',
        tiezi:[],
    };

    router.beforeEach((to, from, next) => {
        switch(to){
            case 'pinglun':
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
        methods: {

        },
    }).$mount('#app');
</script>
</body>
</html>