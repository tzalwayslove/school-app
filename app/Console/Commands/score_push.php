<?php

namespace App\Console\Commands;

use App\Events\ScoreWxTextMessagePush;
use App\Model\Dom\Chengji;
use App\Model\User;
use Illuminate\Console\Command;

class score_push extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'score:push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '用来推送成绩';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $t1 = microtime(true);
        $users = User::all();
        foreach($users as $user){
            try{
                if(!$user->account || !$user->password){
                    continue;
                }
                $chengji = new Chengji($user->account, $user->password);
                $list = $chengji->getChengji();
                $md5 = md5(json_encode($list, JSON_UNESCAPED_UNICODE));
                if($user->score_md5 != $md5){
                    // 推送成绩
                    event(new ScoreWxTextMessagePush($user, $list));
                    $user->score_md5 = $md5;
                    $user->save();
                }
            }catch(\Exception $e){
                dd($e->getMessage(). 'file:'. $e->getFile(). ' line:'.$e->getLine());
                continue;
            }
        }
        $t2 = microtime(true);
        echo '耗时'.round($t2-$t1,3).'秒<br>';
        echo 'Now memory_get_usage: ' . memory_get_usage() . "\n";
        return 1;
    }
}
