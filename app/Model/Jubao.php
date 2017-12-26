<?php

namespace App\Model;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jubao extends Model
{
    protected $table = 'jubao';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    use SoftDeletes;

    public function getUser()
    {
        return $this->belongsTo('App\Model\User', 'user', 'id');
    }

    public function getArticel()
    {
        return $this->belongsTo('App\Model\Articel', 'articel', 'id');
    }
}
