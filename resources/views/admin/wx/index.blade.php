<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('public/vendors/weui/weui.css') }}">
    <script src="{{ asset('public/vendors/weui/zepto.min.js') }}"></script>
    <title></title>
</head>
<body>
<div id="app">
    <div class="page">
        <router-view>

        </router-view>
        <div class="page__bd" style="height: 100%;">
            <div class="weui-tab">
                <div class="weui-tab__panel">

                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function(){
            $('.weui-tabbar__item').on('click', function () {
                $(this).addClass('weui-bar__item_on').siblings('.weui-bar__item_on').removeClass('weui-bar__item_on');
            });
        });
    </script>

    <router-link to="/bar">bar</router-link>

</div>
<script src="{{ asset('public/vendors/vue/vue.js') }}"></script>
<script src="{{ asset('public/vendors/vue/vue-router.js') }}"></script>
<script src="{{ asset('public/vendors/vue/axios.min.js') }}"></script>

<script src="{{ asset('public/vendors/weui/weui.min.js') }}"></script>

<script>

    foo = Vue.component('foo', {
        template:'<div>Foo</div>'
    });

    bar = Vue.component('bar', {
        template:'<div>Bar</div>'
    });
    const routes = [
        { path: '/foo', component: foo },
        { path: '/bar', component: bar }
    ];

    const router = new VueRouter({
        routes: routes
    });

    vue = new Vue({
        router: router,

        data:{

        },

        methods:{

        },

    }).$mount('#app');
</script>
</body>
</html>