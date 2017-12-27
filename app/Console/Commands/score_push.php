<?php

namespace App\Console\Commands;

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
        $users = User::all();
        $send = [];
        foreach($users as $user){
            try{

            }catch(\Exception $e){

            }
        }

    }
}
