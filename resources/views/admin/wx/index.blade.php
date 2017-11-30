<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('public/vendors/weui/weui.css') }}">
    <link rel="stylesheet" href="{{ asset('public/vendors/weui/example.css') }}">
    <script src="{{ asset('public/vendors/weui/zepto.min.js') }}"></script>
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
                    <router-link to="/foo" class="weui-tabbar__item weui-bar__item_on">
                    <span style="display: inline-block;position: relative;">
                        <img src="{{asset('public/images/icon_tabbar.png')}}" alt="" class="weui-tabbar__icon">
                        {{--<span class="weui-badge" style="position: absolute;top: -2px;right: -13px;"></span>--}}
                    </span>
                        <p class="weui-tabbar__label">帖子</p>
                    </router-link>
                    <router-link to="/foo" class="weui-tabbar__item">
                        <img src="{{asset('public/images/icon_tabbar.png')}}" alt="" class="weui-tabbar__icon">
                        <p class="weui-tabbar__label">发布</p>
                    </router-link>
                    <router-link to="/bar" class="weui-tabbar__item">
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
</script>
<script>

    foo = Vue.component('foo', {
        template: '<div class="weui-panel">' +
        '<div class="weui-panel__hd">文字列表附来源</div>' +
        '<div class="weui-panel__bd">' +
        '<div class="weui-media-box weui-media-box_text">' +
        '<h4 class="weui-media-box__title">标题一</h4>' +
        '<p class="weui-media-box__desc">由各种物质组成的巨型球状天体，叫做星球。星球有一定的形状，有自己的运行轨道。</p>' +
        '<ul class="weui-media-box__info">' +
        '<li class="weui-media-box__info__meta">文字来源</li>' +
        '<li class="weui-media-box__info__meta">时间</li>' +
        '<li class="weui-media-box__info__meta weui-media-box__info__meta_extra">其它信息</li>' +
        '</ul>' +
        '</div>' +
        '</div>' +
        '</div>'
    });

    bar = Vue.component('bar', {
        template: '<div>Bar</div>'
    });
    const routes = [
        {path: '/foo', component: foo},
        {path: '/bar', component: bar}
    ];

    const router = new VueRouter({
        routes: routes
    });

    vue = new Vue({
        router: router,

        data: {},

        methods: {},

    }).$mount('#app');
</script>
</body>
</html>