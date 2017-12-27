<?php
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Text;

Route::get('/', function () {
    $user = session('user');
    return view('wx.index', compact('user'));
})->middleware('wx_login');

Route::get('/s', function(){
    session(['a'=>10]);
});


Route::get('/g', function(){
    dd(session('a'));
});

Route::post('upload', 'UploadController@index');
Route::delete('upload', 'UploadController@removeUpload');

Route::get('code', 'Admin\CodeController@index');
Route::post('code', 'Admin\CodeController@gettable');
Route::put('code', 'Admin\CodeController@settable');

Route::get('test', function(){
    $wechatConfig = include 'wechatConfig.php';
    $app = new Application($wechatConfig);



    $message = new Text([
        'content'=>'<a href="http://www.baidu.com">Hello Baidu.com</a>'
    ]);
    $result = $app->staff->message($message)->to('olIXMw6TGnalYlQ8yWCSv76dMnnM')->send();

    dd($result);
});
Route::group([
    'prefix'=>'admin',
    'namespace'=> 'Admin',
    'middleware'=>[
        'auth'
    ]
], function(){
    Route::get('/', 'AdminController@index');
    Route::resource('user', 'UserController');
    Route::resource('cate', 'CateController');
    Route::resource('articel', 'ArticelController');
    Route::resource('comment', 'CommentController');
    Route::resource('setting', 'SettingController');
});

Route::any('wx/login', 'Wx\Login@index');

Route::group([
    'prefix'=>'wx',
    'namespace'=> 'Wx',
    'middleware'=>[
        'wx_login'
    ]
], function(){
    Route::get('/', function(\Illuminate\Http\Request $request){
        echo isset($_GET['echostr'])?$_GET['echostr']:'no echo str';
    });

    Route::get('/articel', 'ArticelController@index');
    Route::get('/comment', 'CommentController@index');
    Route::post('/articel', 'ArticelController@store');
    Route::post('/articel_zan', 'ArticelController@zan');
    Route::post('/comment_zan', 'CommentController@zan');
    Route::post('/addComment', 'CommentController@addComment');
    Route::post('/reply', 'CommentController@reply');
    Route::post('/jubao', 'JubaoController@jubao');

    Route::get('/chengji', function (\Illuminate\Http\Request $request) {
        $user = \App\Model\User::find(\App\Model\User::getId($request->input('user')));
        try{
            $info = $user->getInfo();
        }catch(\App\Exceptions\LoginErrorException $e){
            return redirect('wx/binding?user='.$request->input('user'));
        }

        return view('wx.chengji.index')->withUser($request->input('user'))->withInfo($info);
    });
    Route::get('/chengji_all', function (\Illuminate\Http\Request $request) {
        $user = \App\Model\User::find(\App\Model\User::getId($request->input('user')));
        try{
            $info = $user->getInfo();
        }catch(\App\Exceptions\LoginErrorException $e){
            return redirect('wx/binding?user='.$request->input('user'). '&error=用户名或密码错误');
        }
        return view('wx.chengji_all.index')->withUser($request->input('user'))->withInfo($info);
    });
    Route::get('/kecheng', function(\Illuminate\Http\Request $request){
        $user = \App\Model\User::find(\App\Model\User::getId($request->input('user')));
        try{
            $info = $user->getInfo();
        }catch(\App\Exceptions\LoginErrorException $e){
            return redirect('wx/binding?user='.$request->input('user'). '&error=用户名或密码错误');
        }
        return view('wx.kecheng.index')->withRequest($request)->withUser($user)->withInfo($info);
    });
    Route::get('/kaochang', function(\Illuminate\Http\Request $request){
        $user = \App\Model\User::find(\App\Model\User::getId($request->input('user')));
        try{
            $info = $user->getInfo();
        } catch (\App\Exceptions\LoginErrorException $e){
            return redirect('wx/binding?user='.$request->input('user'));
        }

        return view('wx.kaochang.index')->withUser($request->input('user'))->withInfo($info);
    });
    Route::get('/binding', function(\Illuminate\Http\Request $request){
        $userId = $request->input('user');
        return view('wx.binding.index', compact('userId'));
    });
    Route::post('/binding', 'UserController@binding');
    Route::get('/bind-success', function(){
        return view('wx.binding.success');
    });

    Route::get('/pingjiao', 'UserController@pingjiaoView');
    Route::post('/pingjiao', 'UserController@pingjiao');
    Route::get('/getChengjiOptions', 'UserController@getChengjiOptions');

    Route::get('yikatong/login', 'YikatongController@login');
    Route::post('yikatong/login', 'YikatongController@doLogin');
    Route::get('yikatong/queryList', 'YikatongController@queryList');

    Route::group([
        'middleware'=>['yikatong'],
        'prefix'=>'yikatong',
    ], function(){
        Route::get('liushui', 'YikatongController@index');
        Route::post('liushui', 'YikatongController@getData');
        Route::get('reLogin', 'YikatongController@reLogin');
    });
});

Route::get('/wx/yikatongCode', function(){
    $user_name = 'asdfasdf';
    $password = 'asdf';
    $yikatong = new \App\Model\Dom\YikatongLogin($user_name, $password);
    $code = $yikatong->getCode();
    return response($code, 200, [
        'Content-Type' => 'image/jpeg',
    ]);
});


Route::get('wx_menu', function(){
    $option = require 'wechatConfig.php';
    $app = new Application($option);
    $menu = $app->menu;
    $buttons = [
        [
            "name" => "考试成绩",
            "sub_button"=>[
                [
                    "type" => "click",
                    "name" => "最新成绩",
                    "key"  => "最新成绩"
                ],
                [
                    "type" => "click",
                    "name" => "全部成绩",
                    "key"  => "全部成绩"
                ],
            ]
        ],
        [
            "name" => "课程表",
            "sub_button"=>[
                [
                    "type" => "click",
                    "name" => "本周课程表",
                    "key" => "本周课程表"
                ],
                [
                    "type" => "click",
                    "name" => "全部课程表",
                    "key" => "全部课程表"
                ],
            ]
        ],
        [
            "type" => "click",
            "name" => "我的考场",
            "key" => "考场"
        ]
    ];
        /*[
            "name"       => "菜单",
            "sub_button" => [
                [
                    "type" => "view",
                    "name" => "搜索",
                    "url"  => "http://www.soso.com/"
                ],
                [
                    "type" => "view",
                    "name" => "视频",
                    "url"  => "http://v.qq.com/"
                ],
                [
                    "type" => "click",
                    "name" => "赞一下我们",
                    "key" => "V1001_GOOD"
                ],
            ],
        ],*/
    $res = $menu->add($buttons);
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
