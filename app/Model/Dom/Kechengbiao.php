<?php

namespace App\Model\Dom;


use App\Model\Setting;
use Carbon\Carbon;

class Kechengbiao extends Login
{
    public $weekNum;
    private $diffDay = 0;
    public function __construct($user_name, $password)
    {
        parent::__construct($user_name, $password);

        $start_school = new Carbon(Setting::getOne('start_school'));
        $now = new Carbon(time());

        $this->diffDays = $now->diffInDays($start_school);
        dd($this->diffDays);
        $this->weekNum = intval($this->diffDays / 7);
    }
}
