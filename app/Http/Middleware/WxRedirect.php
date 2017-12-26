<?php

namespace App\Http\Middleware;

use App\Model\User;
use Closure;
use EasyWeChat\Foundation\Application;

class WxRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        /*$wx_user = session('wx_user', false);

        if(!$wx_user){
            $config = include('wechatConfig.php');
            $config['oauth']['callback']= url('/wx/login');
            $app = new Application($config);
            session(['tar_get'=>$request->getRequestUri()]);

            return $app->oauth->scopes(['snsapi_userinfo'])
                ->setRequest($request)
                ->redirect();
        }*/
        dd($request->input('user'));
        if(!$request->input('user') && !session('user')){
            die('请使用微信公众号打开网页');
        }
        $user = User::find($request->input('user'));
        if(!$user){
            die('请使用微信公众号打开网页');
        }
        session(['user'=>$user]);

        return $next($request);
    }
}
