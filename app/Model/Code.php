<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Code extends Model
{
    protected $table = 'code';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    use SoftDeletes;

}
