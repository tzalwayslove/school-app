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
                                                                
}
