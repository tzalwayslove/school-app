<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Articel extends Model
{
    protected $table = 'articel';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    use SoftDeletes;

                                                    public function user_account()
    {
        return $this->belongsTo('App\Model\User', 'user', 'id');
    }
                            public function cate_name()
    {
        return $this->belongsTo('App\Model\Cate', 'cate', 'id');
    }
                                                                
}
