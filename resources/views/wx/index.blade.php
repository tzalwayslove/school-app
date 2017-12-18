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
    <nav class="mui-bar mui-bar-tab" style="background-color: #ffffff;">
        {{-- route link block --}}
        <router-link class="mui-tab-item mui-active mui-active" to="/tiezi">
            <img src="{{ asset('public/wx/img/icon-index.png')}}" class="item-logo">
        </router-link>
        <router-link class="mui-tab-item" to="/fabu">
            <img src="{{ asset('public/wx/img/icon-fabu.png')}}" class="item-logo">
        </router-link>
        <router-link class="mui-tab-item" to="/wode">
            <img src="{{ asset('public/wx/img/icon-wode.png')}}" class="item-logo">
        </router-link>
    </nav>
    <div class="mui-content">
        {{-- route main --}}
        <router-view></router-view>

        {{--<div id="tabbar2" class="mui-control-content">
            <div id="" class="box2">
                <p class="fb-title">发布 <span style="float: right;margin-right: 10px;">匿名</span>
                <div style="float: right; margin-top: -30PX;margin-right: 50px;">

                    <div class="mui-switch mui-active">
                        <div class="mui-switch-handle"></div>
                    </div>
                </div>

                </p>
                <textarea rows="5" maxlength="150" placeholder="写下你想说的话"></textarea>
                <p class="fb-sub">
                    <input type="submit" value="取消"/>
                    <input type="submit" value="发布"/>
                </p>

            </div>

        </div>
        <div id="tabbar3" class="mui-control-content ">
            <div class="box2-t">
                <a><img src="{{asset('public/wx/img/m-touxiang.png')}}" class="box2-t-logo"></a><br/>
                <a style="margin-bottom: 10px;">某同学·男</a><br/>
                <div class="md6" style="border-right: 1px solid #FFFFFF;"><a>帖子 100</a></div>
                <div class="md6"><a>帖子 100</a></div>
                <a href="classtable.html">
                    <div class="md4">
                        <img src="{{asset('public/wx/img/icon-kebiao.png')}}" class="box2-t-logo2"/>
                        <p>课表</p>
                    </div>
                </a>
                <a href="transcript.html">
                    <div class="md4">
                        <img src="{{asset('public/wx/img/icon-cj.png')}}" class="box2-t-logo2"/>
                        <p>成绩</p>
                    </div>
                </a>
                <a href="test-table.html">
                    <div class="md4">
                        <img src="{{asset('public/wx/img/icon-kc.png')}}" class="box2-t-logo2"/>
                        <p>考场</p>
                    </div>
                </a>
                <div class="md4">
                    <img src="{{asset('public/wx/img/icon-xl.png')}}" class="box2-t-logo2"/>
                    <p>校历</p>
                </div>
                <div class="md4">
                    <img src="{{asset('public/wx/img/icon-ts.png')}}" class="box2-t-logo2"/>
                    <p>图书馆</p>
                </div>
                <div class="md4">
                    <img src="{{asset('public/wx/img/icon-kjs.png')}}" class="box2-t-logo2"/>
                    <p>空教室</p>
                </div>
            </div>
            <div class="box2-m">
                <ul class="mui-table-view">
                    <li class="mui-table-view-cell">
                        <a class="mui-navigate-right">
                            校内电话簿
                        </a>
                    </li>
                    <li class="mui-table-view-cell">
                        <a class="mui-navigate-right">
                            教务处网络
                        </a>
                    </li>
                    <li class="mui-table-view-cell">
                        <a class="mui-navigate-right">
                            四六级成绩
                        </a>
                    </li>
                    <li class="mui-table-view-cell">
                        <a class="mui-navigate-right">
                            座位预约
                        </a>
                    </li>
                    <li class="mui-table-view-cell">
                        <a class="mui-navigate-right">
                            忘记密码
                        </a>
                    </li>
                    <li class="mui-table-view-cell">
                        <a class="mui-navigate-right">
                            联系我们
                        </a>
                    </li>
                </ul>
            </div>
        </div>--}}
    </div>
</div>

<script src="{{ asset('public/vue/index.js') }}"></script>
<script src="{{ asset('public/vue/fabu.js') }}"></script>
<script src="{{ asset('public/vue/wode.js') }}"></script>
<script src="{{ asset('public/vue/pinglun.js') }}"></script>
<script src="{{ asset('public/vendors/weui/weui.min.js') }}"></script>
<script>
    $(function () {
//        axios.defaults.baseURL = 'http://school.sz25.net';
        axios.defaults.baseURL = 'http://www.school.dy';
        axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name=csrf-token]').attr('content');

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
                    data.nav_active = to.name;
            }
            next();
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
                router.push({
                    path: '/tiezi'
                })
            }
        }).$mount('#app');
    });
</script>
</body>
</html>