<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <title>遇见</title>
    {{--<script src="{{ asset('public/wx/js/mui.min.js') }}"></script>--}}
    <link href="{{ asset('public/wx/css/mui.css') }}" rel="stylesheet"/>
    <link href="{{ asset('public/wx/css/index.css') }}" rel="stylesheet"/>
</head>
<body>
<div id="#app">
    <nav class="mui-bar mui-bar-tab" style="background-color: #ffffff;">
        <a class="mui-tab-item mui-active mui-active" href="#tabbar1">
            <img src="{{ asset('public/wx/img/icon-index.png')}}" class="item-logo">
        </a>
        <a class="mui-tab-item" href="#tabbar2">
            <img src="{{ asset('public/wx/img/icon-fabu.png')}}" class="item-logo">
        </a>
        <a class="mui-tab-item" href="#tabbar3">
            <img src="{{ asset('public/wx/img/icon-wode.png')}}" class="item-logo">
        </a>
    </nav>
    <div class="mui-content">

        <div id="tabbar1" class="mui-control-content mui-active">
            <div id="segmentedControl" class="mui-segmented-control">
                <div style="padding: 20px 40px;">
                    <a class="mui-control-item mui-active" href="#item1" style="border-radius: 20px 0 0 20px;">最新</a>
                    <a class="mui-control-item" href="#item2" style="border-radius: 0 20px 20px 0;">热门</a>
                </div>
            </div>
            <div>
                <div id="item1" class="mui-control-content mui-active">
                    <div class="mui-content-padded">
                        <div class="yjbox">
                            <img src="{{asset('public/wx/img/m-touxiang.png')}}" class="yjbox-img"/>
                            <p class="yjbox-tl">某同学·男 <a
                                        style="float: right;font-size: 12px;margin-right: 5px;color: #a7a7a7;">11分钟前</a></p>
                            <p class="yj-box-main">“我家常公子天生神力，根本不会武(外)功(挂)。戚家上下29口人都是被毒死的嘻嘻～” <br>“常威！你还说你不会武(外)功(挂）？”</p>
                            <div style="width: 100%;height: 1px;background: #AAAAAA;"></div>
                            <img src="{{asset('public/wx/img/icon-point.png')}}" class="imgicon" style="margin-top: 13px;"/>
                            <div style="float: right; margin-right:5px ;">
                                <img src="{{asset('public/wx/img/icon-heart.png')}}" class="imgicon"/>
                                <p class="icon-num">10</p>
                            </div>
                            <div style="float: right; margin-right:5px ;">
                                <img src="{{ asset('public/wx/img/icon-chat.png') }}" class="imgicon"/>
                                <p class="icon-num">10</p>
                            </div>
                        </div>
                        <div class="yjbox">
                            <img src="{{asset('public/wx/img/m-touxiang.png')}}" class="yjbox-img"/>
                            <p class="yjbox-tl">某同学·男 <a
                                        style="float: right;font-size: 12px;margin-right: 5px;color: #a7a7a7;">11分钟前</a></p>
                            <p class="yj-box-main">“我家常公子天生神力，根本不会武(外)功(挂)。戚家上下29口人都是被毒死的嘻嘻～” <br>“常威！你还说你不会武(外)功(挂）？”</p>
                            <div style="width: 100%;height: 1px;background: #AAAAAA;"></div>
                            <img src="{{asset('public/wx/img/icon-point.png')}}" class="imgicon" style="margin-top: 13px;"/>
                            <div style="float: right; margin-right:5px ;">
                                <img src="{{asset('public/wx/img/icon-heart.png')}}" class="imgicon"/>
                                <p class="icon-num">10</p>
                            </div>
                            <div style="float: right; margin-right:5px ;">
                                <img src="{{ asset('public/wx/img/icon-chat.png') }}" class="imgicon"/>
                                <p class="icon-num">10</p>
                            </div>
                        </div>
                        <div class="yjbox">
                            <img src="{{asset('public/wx/img/m-touxiang.png')}}" class="yjbox-img"/>
                            <p class="yjbox-tl">某同学·男 <a
                                        style="float: right;font-size: 12px;margin-right: 5px;color: #a7a7a7;">11分钟前</a></p>
                            <p class="yj-box-main">“我家常公子天生神力，根本不会武(外)功(挂)。戚家上下29口人都是被毒死的嘻嘻～” <br>“常威！你还说你不会武(外)功(挂）？”</p>
                            <div style="width: 100%;height: 1px;background: #AAAAAA;"></div>
                            <img src="{{asset('public/wx/img/icon-point.png')}}" class="imgicon" style="margin-top: 13px;"/>
                            <div style="float: right; margin-right:5px ;">
                                <img src="{{asset('public/wx/img/icon-heart.png')}}" class="imgicon"/>
                                <p class="icon-num">10</p>
                            </div>
                            <div style="float: right; margin-right:5px ;">
                                <img src="{{ asset('public/wx/img/icon-chat.png') }}" class="imgicon"/>
                                <p class="icon-num">10</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
</body>
</html>