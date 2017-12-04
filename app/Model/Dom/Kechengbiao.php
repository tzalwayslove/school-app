<?php

namespace App\Model\Dom;


use App\Model\Setting;
use Carbon\Carbon;

class Kechengbiao extends Login
{
    public $weekNum;

    public function __construct($user_name, $password)
    {
        parent::__construct($user_name, $password);

        $start_school = new Carbon(Setting::getOne('start_school'));
        $now = new Carbon(date('Y-m-d'));

        $diffDays = $now->diffInDays($start_school);
        $this->weekNum = intval($diffDays / 7);
        $this->getInfo();
    }


}
