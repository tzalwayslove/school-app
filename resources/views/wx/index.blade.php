<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>遇见</title>
    {{--<script src="{{ asset('public/wx/js/mui.min.js') }}"></script>--}}
    <script src="{{ asset('public/vendors/vue/vue.js') }}"></script>
    <script src="{{ asset('public/vendors/vue/vue-router.js') }}"></script>
    <script src="{{ asset('public/vendors/vue/axios.min.js') }}"></script>
    <script src="{{ asset('public/vendors/weui/zepto.min.js') }}"></script>
    <link href="{{ asset('public/wx/css/mui.css') }}" rel="stylesheet"/>
    <link href="{{ asset('public/wx/css/index.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('public/vendors/weui/weui.css') }}">
</head>
<body>

<div id="app">
    <nav class="mui-bar mui-bar-tab" style="background-color: #ffffff;" v-show="bar_buttom">
         {{--route link block--}}
        <router-link
                :class="['mui-tab-item', nav_active == 'tiezi' ? 'mui-active' : '']"
                to="/tiezi">
            {{--<img src="{{ asset('public/wx/img/icon-index.png')}}" class="item-logo">--}}
            <span class="icon-index"></span>
        </router-link>
        <router-link
                :class="['mui-tab-item', nav_active == 'fabu' ? 'mui-active' : '']"
                to="/fabu">
            {{--<img src="{{ asset('public/wx/img/icon-fabu.png')}}" class="item-logo">--}}
            <span class="icon-fabu"></span>
        </router-link>
        <router-link
                :class="['mui-tab-item', nav_active == 'wode' ? 'mui-active' : '']"
                to="/wode">
            {{--<img src="{{ asset('public/wx/img/icon-wode.png')}}" class="item-logo">--}}
            <span class="icon-wode"></span>
        </router-link>
    </nav>
    <div class="mui-content">
        {{-- route main --}}
        <router-view></router-view>
        <div id="toast" style="display: none;" v-show="success">
            <div class="weui-mask_transparent"></div>
            <div class="weui-toast">
                <i class="weui-icon-success-no-circle weui-icon_toast"></i>
                <p class="weui-toast__content">已完成</p>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('public/vue/index.js') }}"></script>
<script src="{{ asset('public/vue/fabu.js') }}"></script>
<script src="{{ asset('public/vue/wode.js') }}"></script>
<script src="{{ asset('public/vue/pinglun.js') }}"></script>
<script src="{{ asset('public/vendors/weui/weui.min.js') }}"></script>
<script src="{{ asset('public/vue/reply.js') }}"></script>
<script src="{{ asset('public/vue/jubao.js') }}"></script>

<script>
    $(function () {
        axios.defaults.baseURL = 'http://school.sz25.net';
//        axios.defaults.baseURL = 'http://www.school.dy';
//        axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');

        const routes = [
            {path: '/tiezi', component: tiezi, name: 'tiezi'},
            {path: '/fabu', component: fabu, name: 'fabu'},
            {path: '/wode', component: wode, name: 'wode'},
            {path: '/pinglun/:id', component: pinglun, name: 'pinglun', props: {articel: 0}},
            {path: '/reply/:id/:niming/:sex/:articel', component: reply, name: 'reply'},
            {path: '/jubao/:articel', component: jubao, name: 'jubao'}
        ];

        router = new VueRouter({
            routes: routes,
        });

        data = {
            nav_active: 'tiezi',
            tiezi: [],
            user: '{{ $user->id }}',
            'bar_buttom': true,
            success:false
        };

        router.beforeEach((to, from, next) => {
            switch (to.name) {
                case "pinglun":
                    data.nav_active = 'tiezi';
                    break;
                default:
                    data.nav_active = to.name;
            }
            next();
            data.bar_buttom = true;
        });
        
        vue = new Vue({
            router: router,
            data: data,
            load: true,
            methods: {
                onClick: function(){
                    console.log(2222222222);
                }
            },
            mounted: function () {
                if(data.success){
                    setTimeout(function(){
                        data.success = false;
                        console.log(data.success);
                    }, 1000);        
                }
            }
        }).$mount('#app');
    });
</script>
</body>
</html>