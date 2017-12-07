<?php

namespace App\Http\Middleware;

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

        $wx_user = session('wx_user', false);

        if(!$wx_user){
            $config = include('wechatConfig.php');
            $config['oauth']['callback']= url('/wx/login');
            $app = new Application($config);

            session(['tar_get'=>$request->getRequestUri()]);

            return $app->oauth->scopes(['snsapi_userinfo'])
                ->setRequest($request)
                ->redirect();
        }

        return $next($request);
    }
}
