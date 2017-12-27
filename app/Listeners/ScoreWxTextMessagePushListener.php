<?php

namespace App\Listeners;

use App\Events\ScoreWxTextMessagePush;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\Text;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScoreWxTextMessagePushListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ScoreWxTextMessagePush  $event
     * @return void
     */
    public function handle(ScoreWxTextMessagePush $event)
    {
        $user = $event->user;
        $list = $event->list;

        if(!$user->open_id){
            return;
        }

        $wechatConfig = include 'wechatConfig.php';
        $app = new Application($wechatConfig);

        $message = new Text('Hello world!');
        $result = $app->customer_service->message($message)->to($user->open_id)->send();

        dd($result);
    }
}
