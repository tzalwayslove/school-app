<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    protected $table = 'comment';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    use SoftDeletes;

    public function articel_id()
    {
        return $this->belongsTo('App\Model\Articel', 'articel', 'id');
    }

    public function getUser()
    {
        return $this->belongsTo('App\Model\User', 'user', 'id');
    }

    public function changeShow($show)
    {
        $this->show = $show ? 1 : 0;
        $this->save();
    }

}
